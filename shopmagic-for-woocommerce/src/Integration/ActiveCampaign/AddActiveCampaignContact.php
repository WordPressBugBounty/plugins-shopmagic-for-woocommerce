<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Integration\ActiveCampaign;

use WPDesk\ShopMagic\FormField\Field\Paragraph;
use WPDesk\ShopMagic\FormField\Field\InputTextField;
use WPDesk\ShopMagic\Workflow\Action\Action;
use WPDesk\ShopMagic\Workflow\Event\DataLayer;

/**
 * @see https://developers.activecampaign.com/reference/overview
 */
final class AddActiveCampaignContact extends Action {

	private ActiveCampaign $active_campaign;

	private Settings $settings;

	public function __construct(
		ActiveCampaign $active_campaign,
		Settings $settings
	) {
		$this->active_campaign = $active_campaign;
		$this->settings        = $settings;
	}

	public function get_id(): string {
		return 'shopmagic_add_to_activecampaign_action';
	}

	public function get_required_data_domains(): array {
		return [];
	}

	public function get_name(): string {
		return __( 'Add a contact to ActiveCampaign list', 'shopmagic-for-woocommerce' );
	}

	/** @return \ShopMagicVendor\WPDesk\Forms\Field[] */
	public function get_fields(): array {
		$fields = parent::get_fields();

		if ( ! $this->settings->has( 'api_key' ) || ! $this->settings->has( 'api_url' ) ) {
			$fields[] = ( new Paragraph() )
				->set_name( 'missing_credentials' )
				->set_type( 'error' )
				->set_description( __( 'Credentials are missing. Obtain ActiveCampaign credentials and update ShopMagic settings.', 'shopmagic-for-woocommerce' ) );

			return $fields;
		}

		$fields[] = ( new InputTextField() )
			->set_name( 'email' )
			->set_label( __( "Contact's email", 'shopmagic-for-woocommerce' ) )
			->set_default_value( '{{ customer.email }}' );
		$fields[] = ( new InputTextField() )
			->set_name( 'first_name' )
			->set_label( __( "Contact's first name", 'shopmagic-for-woocommerce' ) )
			->set_default_value( '{{ customer.first_name }}' );
		$fields[] = ( new InputTextField() )
			->set_name( 'last_name' )
			->set_label( __( "Contact's last name", 'shopmagic-for-woocommerce' ) )
			->set_default_value( '{{ customer.last_name }}' );

		return $fields;
	}

	public function execute( DataLayer $resources ): bool {
		$contact = [
			'email'     => $this->placeholder_processor->process( $this->fields_data->get( 'email' ) ),
			'firstName' => $this->placeholder_processor->process( $this->fields_data->get( 'first_name' ) ),
			'lastName'  => $this->placeholder_processor->process( $this->fields_data->get( 'last_name' ) ),
		];

		return $this->active_campaign->add_contact( $contact );
	}
}
