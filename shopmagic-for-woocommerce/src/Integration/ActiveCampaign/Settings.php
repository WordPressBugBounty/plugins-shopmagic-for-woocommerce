<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Integration\ActiveCampaign;

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
		return __( 'ActiveCampaign', 'shopmagic-for-woocommerce' );
	}

	public static function get_tab_slug(): string {
		return 'activecampaign';
	}

	public static function get_settings_persistence(): PersistentContainer {
		return new JsonSerializedOptionsContainer( 'shopmagic_activecampaign_settings' );
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
				->set_label( __( 'API Key', 'shopmagic-for-woocommerce' ) )
				->set_description( sprintf( __( 'Add API Key %s', 'shopmagic-for-woocommerce' ), '<a href="https://help.activecampaign.com/hc/en-us/articles/207317590-Getting-started-with-the-API#h_01HJ6REM2YQW19KYPB189726ST" target="_blank">( Settings &rarr; Developer &rarr; Key )</a>' ) )
				->set_name( 'api_key' ),
			( new InputTextField() )
				->set_label( __( 'API Url', 'shopmagic-for-woocommerce' ) )
				->set_description( sprintf( __( 'Add API Url %s', 'shopmagic-for-woocommerce' ), '<a href="https://help.activecampaign.com/hc/en-us/articles/207317590-Getting-started-with-the-API#h_01HJ6REM2YQW19KYPB189726ST" target="_blank">( Settings &rarr; Developer &rarr; Url )</a>' ) )
				->set_name( 'api_url' ),
		];
	}
}
