<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin\Product;

use WPDesk\ShopMagic\Workflow\Event\Builtin\ProductCommonEvent;

final class ProductEdit extends ProductCommonEvent {

	public function get_id(): string {
		return 'shopmagic_product_updated';
	}

	public function get_name(): string {
		return esc_html__( 'Product updated', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return esc_html__( 'Run automation when a product is updated.', 'shopmagic-for-woocommerce' );
	}

	public function initialize(): void {
		add_action(
			'woocommerce_update_product',
			function ( $product_id, $product ): void {
				$this->handle_product_updated( $product_id, $product );
			},
			10,
			2
		);
	}

	/**
	 * @param int|string $product_id
	 * @param mixed      $product
	 */
	private function handle_product_updated( $product_id, $product ): void {
		if ( $product instanceof \WC_Product ) {
			$this->resources->set( \WC_Product::class, $product );
			$this->trigger_automation();
			return;
		}

		$product = wc_get_product( $product_id );
		if ( ! $product instanceof \WC_Product ) {
			return;
		}

		$this->resources->set( \WC_Product::class, $product );
		$this->trigger_automation();
	}
}
