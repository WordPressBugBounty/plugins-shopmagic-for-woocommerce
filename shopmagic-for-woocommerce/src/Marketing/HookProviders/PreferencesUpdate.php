<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Marketing\HookProviders;

use ShopMagicVendor\WPDesk\Forms\Field\CheckboxField;
use WPDesk\ShopMagic\Components\HookProvider\HookProvider;
use WPDesk\ShopMagic\Marketing\Subscribers\ListSubscriber\SubscriptionManager;
use WPDesk\ShopMagic\Marketing\Subscribers\PreferencesRoute;
use WPDesk\ShopMagic\Marketing\Util\EmailHasher;

/**
 * Handle updating customer marketing (communication) preferences. At the moment it works only
 * for guests and customers, though we are able to create subscriber which is not a guest entity.
 * (This shouldn't be possible, check if guest is created each time it's saved on marketing list).
 */
final class PreferencesUpdate implements HookProvider {

	public const NONCE_ACTION = 'shopmagic_communication_preferences';

	public const NONCE_NAME = 'shopmagic_preferences_nonce';

	/**
	 * @var string
	 */
	private const EMAIL = 'email';

	private SubscriptionManager $subscription_manager;

	private EmailHasher $email_hasher;

	public function __construct( SubscriptionManager $manager, EmailHasher $email_hasher ) {
		$this->subscription_manager = $manager;
		$this->email_hasher         = $email_hasher;
	}

	public function hooks(): void {
		add_action( 'wp_ajax_' . PreferencesRoute::get_slug(), [ $this, 'process_account_preferences' ] );
		add_action( 'wp_ajax_nopriv_' . PreferencesRoute::get_slug(), [ $this, 'process_account_preferences' ] );
		add_action( 'admin_post_' . PreferencesRoute::get_slug(), [ $this, 'process_account_preferences' ] );
		add_action( 'admin_post_nopriv_' . PreferencesRoute::get_slug(), [ $this, 'process_account_preferences' ] );
	}

	public function process_account_preferences(): void {
		$nonce = isset( $_POST[ self::NONCE_NAME ] ) ? sanitize_text_field( wp_unslash( $_POST[ self::NONCE_NAME ] ) ) : '';

		if ( wp_verify_nonce( $nonce, self::NONCE_ACTION ) !== 1 ) {
			// Explicitly check for 0-12h validity.
			$this->handle_failure();
		}

		$sanitized_post = array_map(
			static function ( $field ) {
				if ( \is_array( $field ) ) {
					return array_map( 'sanitize_text_field', $field );
				}

				return sanitize_text_field( $field );
			},
			isset( $_POST['shopmagic_optin'] ) ? wp_unslash( $_POST['shopmagic_optin'] ) : []
		);

		$email = isset( $_POST[ self::EMAIL ] ) ? sanitize_email( wp_unslash( $_POST[ self::EMAIL ] ) ) : '';

		$hash = isset( $_POST['hash'] ) ? sanitize_text_field( wp_unslash( $_POST['hash'] ) ) : '';

		if ( empty( $email ) || ! $this->email_hasher->valid( $email, $hash ) ) {
			$this->handle_failure();
		}

		$this->save_opt_changes( $email, $sanitized_post );
		$this->handle_success();
	}

	private function handle_failure(): void {
		if ( wp_doing_ajax() ) {
			wp_send_json_error( [ 'message' => __( 'Invalid request.', 'shopmagic-for-woocommerce' ) ], 403 );
		}

		$referer = wp_get_referer();
		wp_safe_redirect( add_query_arg( [ 'success' => 0 ], $referer ? $referer : home_url() ) );
		exit;
	}

	private function handle_success(): void {
		if ( wp_doing_ajax() ) {
			wp_send_json_success();
		}

		$referer = wp_get_referer();
		wp_safe_redirect( add_query_arg( [ 'success' => 1 ], $referer ? $referer : home_url() ) );
		exit;
	}

	/**
	 * @param string[] $request
	 */
	private function save_opt_changes( string $email, array $request ): void {
		$preferences = $this->subscription_manager->get_repository()->find_by( [ self::EMAIL => $email ] );

		foreach ( $preferences as $preference ) {
			if (
				isset( $request[ $preference->get_list_id() ] ) &&
				in_array( $request[ $preference->get_list_id() ], [ CheckboxField::VALUE_TRUE, '1' ] )
			) {
				$preference->set_active( true );
			} else {
				$preference->set_active( false );
			}

			$this->subscription_manager->save( $preference );
		}
	}
}
