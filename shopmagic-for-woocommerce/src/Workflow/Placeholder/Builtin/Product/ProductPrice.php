<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Product;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\WooCommerceProductBasedPlaceholder;

final class ProductPrice extends WooCommerceProductBasedPlaceholder {

	public function get_slug(): string {
		return 'price';
	}

	public function get_description(): string {
		return esc_html__( 'Display price of current product.', 'shopmagic-for-woocommerce' );
	}

	public function value( array $parameters ): string {
		if ( $this->resources->has( \WC_Product::class ) ) {
			return (string) $this->get_product()->get_price();
		}

		return '';
	}
}
