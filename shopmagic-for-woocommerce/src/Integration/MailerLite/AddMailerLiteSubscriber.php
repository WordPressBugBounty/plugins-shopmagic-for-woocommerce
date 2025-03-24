<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Integration\MailerLite;

use WPDesk\ShopMagic\FormField\Field\InputTextField;
use WPDesk\ShopMagic\FormField\Field\Paragraph;
use WPDesk\ShopMagic\FormField\Field\SelectField;
use WPDesk\ShopMagic\Workflow\Action\Action;
use WPDesk\ShopMagic\Workflow\Event\DataLayer;

/**
 * @see https://github.com/mailerlite/mailerlite-php
 * @see https://developers.mailerlite.com/docs/subscribers.html#create-upsert-subscriber
 */
final class AddMailerLiteSubscriber extends Action {

	private APITools $mailer_lite;

	private Settings $settings;

	public function __construct(
		APITools $mailer_lite,
		Settings $settings
	) {
		$this->settings    = $settings;
		$this->mailer_lite = $mailer_lite;
	}

	public function get_id(): string {
		return 'shopmagic_add_to_mailerlite_action';
	}

	public function get_required_data_domains(): array {
		return [];
	}

	public function get_name(): string {
		return __( 'Add a contact to MailerLite Subscribers list', 'shopmagic-for-woocommerce' );
	}

	/** @return \ShopMagicVendor\WPDesk\Forms\Field[] */
	public function get_fields(): array {
		$fields = parent::get_fields();

		if ( ! $this->settings->is_api_token_valid() ) {
			$fields[] = ( new Paragraph() )
				->set_name( 'missing_api_token' )
				->set_type( 'error' )
				->set_description(
					__(
						'API token is missing. Generate MailerLite API token and update ShopMagic settings.',
						'shopmagic-for-woocommerce'
					)
				);

			return $fields;
		}

		$fields[] = ( new InputTextField() )
			->set_name( 'email' )
			->set_label( __( "Subscriber's email", 'shopmagic-for-woocommerce' ) )
			->set_default_value( '{{ customer.email }}' );

		$fields[] = ( new InputTextField() )
			->set_name( 'first_name' )
			->set_label( __( "Subscriber's first name", 'shopmagic-for-woocommerce' ) )
			->set_default_value( '{{ customer.first_name }}' );

		$fields[] = ( new InputTextField() )
			->set_name( 'last_name' )
			->set_label( __( "Subscriber's last name", 'shopmagic-for-woocommerce' ) )
			->set_default_value( '{{ customer.last_name }}' );

		$groups = $this->mailer_lite->get_groups();

		if ( ! empty( $groups ) ) {
			$fields[] = ( new SelectField() )
				->set_name( '_mailer_lite_group_ids' )
				->set_label( __( 'Select a group to assign', 'shopmagic-for-woocommerce' ) )
				->set_options( $groups )
				->set_multiple()
				->set_default_value( (string) array_keys( $groups )[0] );
		} else {
			$fields[] = ( new Paragraph() )
				->set_name( 'groups_missing' )
				->set_label( __( 'Select a group to assign', 'shopmagic-for-woocommerce' ) )
				->set_placeholder(
					__(
						'No groups assigned to your account were found. To add groups, go to your MailerLite panel.',
						'shopmagic-for-woocommerce'
					)
				);
		}

		return $fields;
	}

	public function execute( DataLayer $resources ): bool {
		$subscriber = [
			'email'         => $this->placeholder_processor->process( $this->fields_data->get( 'email' ) ),
			'groups'        => $this->get_selected_groups(),
			'fields'        => [
				'name'      => $this->placeholder_processor->process( $this->fields_data->get( 'first_name' ) ),
				'last_name' => $this->placeholder_processor->process( $this->fields_data->get( 'last_name' ) ),
			],
			'status'        => 'active',
			'subscribed_at' => wp_date( 'Y-m-d H:i:s' ),
		];

		return $this->mailer_lite->create_subscriber( $subscriber );
	}

	private function get_selected_groups(): array {
		$groups = [];

		foreach ( $this->fields_data->get( '_mailer_lite_group_ids' ) as $group_id ) {
			$group_id = str_replace( 'id_', '', $group_id );

			$groups[] = (int) $group_id;
		}

		return $groups;
	}
}
