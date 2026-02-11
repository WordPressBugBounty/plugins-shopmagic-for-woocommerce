<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Filter\Builtin;

use WPDesk\ShopMagic\Workflow\Components\Groups;
use WPDesk\ShopMagic\Workflow\Filter\FilterUsingComparisonTypes;

abstract class ProductFilter extends FilterUsingComparisonTypes {

	public function get_group_slug(): string {
		return Groups::PRODUCT;
	}

	public function get_required_data_domains(): array {
		return [ \WC_Product::class ];
	}

	protected function get_product(): \WC_Product {
		return $this->resources->get( \WC_Product::class );
	}
}
