<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;
use WPDesk\ShopMagic\Workflow\Placeholder\Helper\PlaceholderUTMBuilder;
use WPDesk\ShopMagic\Workflow\Placeholder\TemplateRendererForPlaceholders;

class OrderQuantityProducts extends WooCommerceOrderBasedPlaceholder {

	/** @var TemplateRendererForPlaceholders */
	private $renderer;

	/** @var PlaceholderUTMBuilder */
	private $utm_builder;

	public function __construct( TemplateRendererForPlaceholders $renderer, PlaceholderUTMBuilder $utm_builder ) {
		$this->renderer    = $renderer;
		$this->utm_builder = $utm_builder;
	}

	public function get_description(): string {
		return esc_html__( 'Display current ordered products with their quantity.', 'shopmagic-for-woocommerce' ) . '\n' .
				$this->utm_builder->get_description();
	}

	public function get_slug(): string {
		return 'quantity_products';
	}

	public function get_supported_parameters( $values = null ): array {
		return array_merge( $this->utm_builder->get_utm_fields(), $this->renderer->get_template_selector_field() );
	}

	public function value( array $parameters ): string {
		if ( ! $this->resources->has( \WC_Order::class ) ) {
			return '';
		}

		$items = $this->resources->get( \WC_Order::class )->get_items();

		return $this->renderer->render(
			'placeholder/quantity_products/' . ( $parameters['template'] ?? 'grid_2_col' ),
			[
				'order_items' => $items,
				'parameters'  => $parameters,
				'utm_builder' => $this->utm_builder,
			]
		);
	}
}
