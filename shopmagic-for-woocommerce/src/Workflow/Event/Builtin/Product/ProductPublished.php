<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin\Product;

use WPDesk\ShopMagic\Workflow\Event\Builtin\ProductCommonEvent;

final class ProductPublished extends ProductCommonEvent {

	public function get_id(): string {
		return 'shopmagic_product_published';
	}

	public function get_name(): string {
		return esc_html__( 'Product published', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return esc_html__( 'Run automation when a product is published. Runs every time status changes to publish.', 'shopmagic-for-woocommerce' );
	}

	public function initialize(): void {
		add_action(
			'transition_post_status',
			function ( string $new_status, string $old_status, \WP_Post $post ): void {
				$this->handle_product_published( $new_status, $old_status, $post );
			},
			10,
			3
		);
	}

	private function handle_product_published( string $new_status, string $old_status, \WP_Post $post ): void {
		if ( $post->post_type !== 'product' ) {
			return;
		}
		if ( 'publish' !== $new_status ) {
			return;
		}
		if ( 'publish' === $old_status ) {
			return;
		}

		$product = wc_get_product( $post->ID );
		if ( ! $product instanceof \WC_Product ) {
			return;
		}

		$this->resources->set( \WC_Product::class, $product );
		$this->trigger_automation();
	}
}
