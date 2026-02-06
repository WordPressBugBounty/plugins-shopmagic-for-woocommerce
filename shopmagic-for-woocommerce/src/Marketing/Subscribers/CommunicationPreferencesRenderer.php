<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Marketing\Subscribers;

use ShopMagicVendor\WPDesk\View\Renderer\Renderer;
use WPDesk\ShopMagic\Customer\Customer;
use WPDesk\ShopMagic\Marketing\Subscribers\ListSubscriber\SubscriberObjectRepository;
use WPDesk\ShopMagic\Marketing\Subscribers\ListSubscriber\SingleListSubscriber;
use WPDesk\ShopMagic\Marketing\Util\EmailObsufcator;
use WPDesk\ShopMagic\Marketing\Util\EmailHasher;

/**
 * Helper class responsible for rendering communication preferences page.
 */
class CommunicationPreferencesRenderer {

	private Renderer $renderer;

	private EmailObsufcator $obfuscator;

	private SubscriberObjectRepository $subscribers_repository;

	private EmailHasher $email_hasher;

	public function __construct(
		Renderer $renderer,
		EmailObsufcator $obfuscator,
		SubscriberObjectRepository $subscribers_repository,
		EmailHasher $email_hasher
	) {
		$this->renderer               = $renderer;
		$this->obfuscator             = $obfuscator;
		$this->subscribers_repository = $subscribers_repository;
		$this->email_hasher           = $email_hasher;
	}

	public function render_wrap_start(): string {
		return $this->renderer->render( 'marketing-lists/communication_preferences_wrap_start' );
	}

	public function render_wrap_end(): string {
		return $this->renderer->render( 'marketing-lists/communication_preferences_wrap_end' );
	}

	/**
	 * @param Customer $customer
	 * @param array{
	 *     obfuscate?: bool,
	 *     success?: bool
	 * }               $params
	 *
	 * @return string
	 */
	public function render( Customer $customer, array $params = [] ): string {
		$params = array_merge(
			[
				'obfuscate' => true,
				'success'   => null,
			],
			$params
		);

		$email = $params['obfuscate'] === true
			? $this->obfuscator->obfuscate( $customer->get_email() )
			: $customer->get_email();

		return $this->renderer->render(
			'marketing-lists/communication_preferences',
			[
				'success'       => $params['success'],
				'email'         => $customer->get_email(),
				'email_display' => $email,
				'action'        => PreferencesRoute::get_slug(),
				'hash'          => $this->email_hasher->hash( $customer->get_email() ),
				'signed_ups'    => array_filter(
					iterator_to_array(
						$this->subscribers_repository->find_by(
							[
								'email'  => $customer->get_email(),
								'active' => 1,
							]
						)
					),
					function ( SingleListSubscriber $list_status ) {
						$post = get_post( $list_status->get_list_id() );
						return $post && $post->post_status === 'publish';
					}
				),
			]
		);
	}
}
