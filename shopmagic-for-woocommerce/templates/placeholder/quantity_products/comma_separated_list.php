<?php
/**
 * @var WC_Order_Item[]                                                     $order_items
 * @var string[]                                                            $parameters
 * @var \WPDesk\ShopMagic\Workflow\Placeholder\Helper\PlaceholderUTMBuilder $utm_builder
 */

$items_formatted = array_map(
	static function ( $item ) {
		$product_name = $item->get_product()->get_name();
		$quantity     = $item->get_quantity();

		return sprintf(
		/* translators: 1: product name, 2: product quantity */
			esc_html__( '%1$s - Quantity: %2$s', 'shopmagic-for-woocommerce' ),
			$product_name,
			$quantity
		);
	},
	$order_items
);

echo esc_html( implode( ', ', $items_formatted ) );
