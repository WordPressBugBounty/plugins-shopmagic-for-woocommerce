<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Frontend\Interceptor;

use ShopMagicVendor\Psr\Log\LoggerAwareTrait;
use ShopMagicVendor\Psr\Log\LoggerInterface;
use ShopMagicVendor\Psr\Log\NullLogger;
use ShopMagicVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use WPDesk\ShopMagic\Admin\Settings\GeneralSettings;
use WPDesk\ShopMagic\Components\HookProvider\Conditional;
use WPDesk\ShopMagic\Customer\Customer;
use WPDesk\ShopMagic\Customer\CustomerProvider;
use WPDesk\ShopMagic\Customer\CustomerRepository;
use WPDesk\ShopMagic\Customer\Guest\Guest;
use WPDesk\ShopMagic\Customer\Guest\GuestDataAccess;
use WPDesk\ShopMagic\Customer\Guest\GuestFactory;
use WPDesk\ShopMagic\Exception\CannotProvideCustomerException;
use WPDesk\ShopMagic\Exception\CustomerNotFound;
use WPDesk\ShopMagic\Helper\RestRequestUtil;
use WPDesk\ShopMagic\Frontend\Session\CookiePersistence;
use WPDesk\ShopMagic\Helper\WordPressPluggableHelper;
use function WC;

/**
 * @deprecated 4.3.0 Use {@see CompositeCustomerProvider}, or {@see SessionCustomerProvider} if relying only on session data.
 */
final class CurrentCustomer implements Hookable, CustomerProvider, Conditional {
	use LoggerAwareTrait;

	/** @var string */
	private const SESSION_TRACKING_DATA_KEY = 'shopmagic_customer_token';
	/** @var string */
	private const META = 'meta';
	/** @var string */
	private const USER_ID = 'user_id';
	/** @var string */
	private const EMAIL = 'email';

	/** @var GuestDataAccess */
	private $guest_manager;

	/** @var GuestFactory */
	private $guest_factory;

	/** @var CookiePersistence */
	private $cookie_persistence;

	/** @var array{user_id?: int|numeric-string, email?: string, meta: string[]} */
	private $tracking_data = [ self::META => [] ];

	/** @var CustomerRepository */
	private $customer_repository;

	public function __construct(
		CustomerRepository $customer_repository,
		GuestDataAccess $guest_manager,
		GuestFactory $guest_factory,
		?LoggerInterface $logger = null
	) {
		$this->customer_repository = $customer_repository;
		$this->guest_manager       = $guest_manager;
		$this->guest_factory       = $guest_factory;
		$this->logger              = $logger ?? new NullLogger();

		if ( ! self::is_needed() ) {
			return;
		}

		$this->cookie_persistence = new CookiePersistence();

		$this->tracking_data = $this->get_decoded_tracking_data();
		$this->refresh_tracking_user_id();
	}

	public static function is_needed(): bool {
		$enabled = WordPressPluggableHelper::is_plugin_active( 'woocommerce/woocommerce.php' ) &&
					filter_var( GeneralSettings::get_option( 'enable_session_tracking', true ), \FILTER_VALIDATE_BOOLEAN );

		if ( is_admin() && ! wp_doing_ajax() ) {
			$request_valid = false;
		} elseif ( RestRequestUtil::is_rest_request() ) {
			$request_valid = false;
		} elseif ( wp_doing_cron() ) {
			$request_valid = false;
		} else {
			$request_valid = true;
		}

		return $enabled && $request_valid;
	}

	/**
	 * @return array{user_id?: int|numeric-string, email?: string, meta: string[]}
	 */
	private function get_decoded_tracking_data(): array {
		$data = null;
		if ( function_exists( 'WC' ) && WC()->session instanceof \WC_Session ) {
			$raw_data = WC()->session->get( self::SESSION_TRACKING_DATA_KEY );
			if ( is_string( $raw_data ) && $raw_data !== '' ) {
				$data = json_decode( $raw_data, true );
			}
		} else {
			$this->logger->warning( 'Failed to retrieve customer tracking data. WC session not found.' );
		}

		$data = is_array( $data ) ? $data : $this->cookie_persistence->get_tracking_data();
		unset( $data['hash'] );

		return $data + [ self::META => [] ];
	}

	/**
	 * @internal
	 */
	public function refresh_tracking_user_id(): void {
		if ( is_user_logged_in() ) {
			$this->set_user_id( (int) wp_get_current_user()->ID );
		}
	}

	private function set_user_id( int $user_id ): void {
		$this->tracking_data[ self::USER_ID ] = $user_id;
		/**
		 * @ignore Action used to internally sync customer status with other interceptors.
		 */
		do_action( 'shopmagic/core/customer_interceptor/changed', $this->tracking_data );
	}

	public function set_meta( string $meta_name, string $meta_value ): void {
		$this->tracking_data[ self::META ][ $meta_name ] = $meta_value;
	}

	public function is_customer_provided(): bool {
		try {
			return $this->get_customer() instanceof Customer;
		} catch ( CannotProvideCustomerException $e ) {
			return false;
		}
	}

	/**
	 * @return Customer
	 * @throws CannotProvideCustomerException
	 */
	public function get_customer(): Customer {
		if ( is_user_logged_in() ) {
			return $this->customer_repository->fetch_user( new \WP_User( get_current_user_id() ) );
		}

		if ( isset( $this->tracking_data[ self::USER_ID ] ) ) {
			$user = get_user_by( 'id', $this->tracking_data[ self::USER_ID ] );
			if ( $user instanceof \WP_User ) {
				return $this->customer_repository->fetch_user( $user );
			}
		}

		if ( isset( $this->tracking_data[ self::EMAIL ] ) ) {
			try {
				// @todo: save metadata each time we intercept some customer, even known one
				return $this->customer_repository->find_by_email( $this->tracking_data[ self::EMAIL ] );
			} catch ( CustomerNotFound $e ) {
				$guest = $this->guest_factory->from_email( $this->tracking_data[ self::EMAIL ] );
				foreach ( $this->tracking_data[ self::META ] as $meta_key => $meta_value ) {
					$guest->add_meta( $meta_key, $meta_value );
				}

				if ( ( \is_array( $this->tracking_data[ self::META ] ) || $this->tracking_data[ self::META ] instanceof \Countable ? \count( $this->tracking_data[ self::META ] ) : 0 ) > 0 ) {
					$this->guest_manager->save( $guest );
				}

				return $guest;
			}
		}

		throw new CannotProvideCustomerException( 'Customer is not available' );
	}

	public function hooks(): void {
		if ( ! $this->is_enabled_session_tracking() ) {
			return;
		}

		add_action(
			'wp',
			function () {
				$this->remember_tracking_key();
			},
			99
		);
		add_action(
			'shutdown',
			function () {
				$this->remember_tracking_key();
			},
			0
		);
		add_action(
			'set_logged_in_cookie',
			function () {
				$this->refresh_tracking_user_id();
			}
		);
		add_action(
			'comment_post',
			function ( int $comment_id ) {
				$this->capture_from_comment( $comment_id );
			}
		);
		add_action(
			'woocommerce_new_order',
			function ( $order_id, $order = null ) {
				$this->capture_from_order( $order_id, $order );
			},
			10,
			2
		);
		add_action(
			'woocommerce_api_create_order',
			function ( $order_id, $order = null ) {
				$this->capture_from_order( $order_id, $order );
			},
			10,
			2
		);
	}

	private function is_enabled_session_tracking(): bool {
		return filter_var(
			GeneralSettings::get_option( 'enable_session_tracking', true ),
			\FILTER_VALIDATE_BOOLEAN
		);
	}

	/**
	 * @internal
	 */
	public function remember_tracking_key(): void {
		if ( WC()->session instanceof \WC_Session ) {
			WC()->session->set( self::SESSION_TRACKING_DATA_KEY, json_encode( $this->tracking_data ) );
		}

		$this->cookie_persistence->save_tracking_data( $this->tracking_data );
	}

	/**
	 * @internal
	 */
	public function capture_from_comment( int $comment_id ): void {
		if ( is_user_logged_in() ) {
			return;
		}

		$comment = get_comment( $comment_id );
		if ( ! $comment ) {
			return;
		}
		if ( $comment->user_id ) {
			return;
		}
		$this->set_user_email( $comment->comment_author_email );
	}

	public function set_user_email( string $email ): void {
		$this->tracking_data[ self::EMAIL ] = $email;
		/**
		 * @ignore Action used to internally sync customer status with other interceptors.
		 */
		do_action( 'shopmagic/core/customer_interceptor/changed', $this->tracking_data );
	}

	public function capture_from_order( $order_id, $order = null ): void {
		if ( is_user_logged_in() ) {
			return;
		}

		if ( ! $order instanceof \WC_Abstract_Order ) {
			$order = wc_get_order( $order_id );
		}

		$this->set_user_email( $order->get_billing_email() );
	}

	/**
	 * Save or update currently intercepted guest to database. This doesn't work for registered users.
	 *
	 * @throws CannotProvideCustomerException
	 */
	public function persist_current_customer(): void {
		$customer = $this->get_customer();

		if ( ! $customer instanceof Guest ) {
			return;
		}

		foreach ( $this->tracking_data[ self::META ] as $key => $value ) {
			$customer->add_meta( $key, $value );
		}

		$this->guest_manager->save( $customer );
	}
}
