<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Shop;

use WPDesk\ShopMagic\Workflow\Placeholder\Placeholder;

final class AdminEmail extends Placeholder {

	public function get_slug(): string {
		return 'admin_email';
	}

	public function get_description(): string {
		return esc_html__( 'Display admin email of your website.', 'shopmagic-for-woocommerce' );
	}

	public function get_required_data_domains(): array {
		return [];
	}

	public function value( array $parameters ): string {
		return get_bloginfo( 'admin_email' );
	}
}
