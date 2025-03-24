<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Integration\MailerLite;

use ShopMagicVendor\WPDesk\Forms\Field;
use ShopMagicVendor\WPDesk\Persistence\PersistentContainer;
use WPDesk\ShopMagic\Admin\Settings\FieldSettingsTab;
use WPDesk\ShopMagic\Components\Persistence\JsonSerializedOptionsContainer;
use WPDesk\ShopMagic\FormField\Field\InputTextField;

final class Settings extends FieldSettingsTab {

	private PersistentContainer $persistence;

	public function __construct( PersistentContainer $persistence ) {
		$this->persistence = $persistence;
	}

	public function get_tab_name(): string {
		return __( 'MailerLite', 'shopmagic-for-woocommerce' );
	}

	public static function get_tab_slug(): string {
		return 'mailerlite';
	}

	public static function get_settings_persistence(): PersistentContainer {
		return new JsonSerializedOptionsContainer( 'shopmagic_mailerlite_settings' );
	}

	public function get( string $key, $default = false ) {
		if ( $this->persistence->has( $key ) ) {
			return $this->persistence->get( $key );
		}

		return $default;
	}

	public function has( string $key ): bool {
		return $this->persistence->has( $key );
	}

	/** @return Field[] */
	public function get_fields(): array {
		return [
			( new InputTextField() )
				->set_label( __( 'API Token', 'shopmagic-for-woocommerce' ) )
				->set_description( sprintf( __( 'Add API token. To create token click %s', 'shopmagic-for-woocommerce' ), '<a href="https://dashboard.mailerlite.com/integrations/api" target="_blank">here &rarr;</a>' ) )
				->set_name( 'api_token' ),
		];
	}

	public function is_api_token_valid(): bool {
		if ( ! $this->has( 'api_token' ) || empty( $this->get( 'api_token' ) ) ) {
			return false;
		}

		return count( explode( '.', $this->get( 'api_token' ) ) ) === 3;
	}
}
