<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\DataSharing;

use WPDesk\ShopMagic\Workflow\Event\DataLayer;

class ProductTestProvider implements DataProvider {

	public function get_provided_data_domains(): array {
		return [ \WC_Product::class ];
	}

	public function get_provided_data(): DataLayer {
		$product = $this->get_product();

		return new DataLayer( [ \WC_Product::class => $product ] );
	}

	private function get_product(): \WC_Product {
		[ $product ] = wc_get_products(
			[
				'limit'   => 1,
				'orderby' => 'date',
				'order'   => 'DESC',
				'status'  => [ 'publish' ],
			]
		);

		if ( $product instanceof \WC_Product ) {
			return $product;
		}

		return $this->get_stub_product_data();
	}

	private function get_stub_product_data(): \WC_Product {
		return new class() extends \WC_Product_Simple {

			/**
			 * @var int[]|string[]|mixed[][]|bool[]|null[]|mixed[]
			 */
			protected $data = [
				'name'               => 'ShopMagic Test Product',
				'slug'               => 'shopmagic-test-product',
				'date_created'       => null,
				'date_modified'      => null,
				'status'             => 'publish',
				'featured'           => false,
				'catalog_visibility' => 'visible',
				'description'        => '',
				'short_description'  => '',
				'sku'                => '',
				'price'              => '',
				'regular_price'      => '',
				'sale_price'         => '',
				'date_on_sale_from'  => null,
				'date_on_sale_to'    => null,
				'total_sales'        => '0',
				'tax_status'         => 'taxable',
				'tax_class'          => '',
				'manage_stock'       => false,
				'stock_quantity'     => null,
				'stock_status'       => 'instock',
				'backorders'         => 'no',
				'low_stock_amount'   => '',
				'sold_individually'  => false,
				'weight'             => '',
				'length'             => '',
				'width'              => '',
				'height'             => '',
				'upsell_ids'         => [],
				'cross_sell_ids'     => [],
				'parent_id'          => 0,
				'reviews_allowed'    => true,
				'purchase_note'      => '',
				'attributes'         => [],
				'default_attributes' => [],
				'menu_order'         => 0,
				'post_password'      => '',
				'virtual'            => false,
				'downloadable'       => false,
				'category_ids'       => [],
				'tag_ids'            => [],
				'shipping_class_id'  => 0,
				'downloads'          => [],
				'image_id'           => '',
				'gallery_image_ids'  => [],
				'download_limit'     => -1,
				'download_expiry'    => -1,
				'rating_counts'      => [],
				'average_rating'     => 0,
				'review_count'       => 0,
			];
		};
	}
}
