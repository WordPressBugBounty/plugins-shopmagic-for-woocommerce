<?php
/**
 * @var WC_Order_Item[] $order_items
 * @var string[] $parameters
 * @var \WPDesk\ShopMagic\Workflow\Placeholder\Helper\PlaceholderUTMBuilder $utm_builder
 */

?>
<ul class="shopmagic-order-items">
	<?php foreach ( $order_items as $item ) : ?>
		<?php $product = $item->get_product(); ?>
		<li>
			<a href="<?php echo esc_url( $utm_builder->append_utm_parameters_to_uri( $parameters, $product->get_permalink() ) ); ?>">
				<?php echo esc_html( $product->get_name() ); ?>
			</a>
			<p>
				<?php
				printf(
					/* translators: %s: quantity of this item */
					esc_html__( 'Quantity: %s', 'shopmagic-for-woocommerce' ),
					absint( $item->get_quantity() )
				);
				?>
			</p>
		</li>
	<?php endforeach; ?>
</ul>
