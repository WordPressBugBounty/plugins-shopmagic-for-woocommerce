<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin;

use WPDesk\ShopMagic\Workflow\Components\Groups;
use WPDesk\ShopMagic\Workflow\Event\Event;

abstract class ProductCommonEvent extends Event {

	public function get_group_slug(): string {
		return Groups::PRODUCT;
	}

	public function get_provided_data_domains(): array {
		return array_merge(
			parent::get_provided_data_domains(),
			[ \WC_Product::class ]
		);
	}

	/**
	 * @return array{product_id: numeric-string|int} Normalized event data required for Queue serialization.
	 */
	public function jsonSerialize(): array {
		return [
			'product_id' => $this->get_product()->get_id(),
		];
	}

	private function get_product(): \WC_Product {
		return $this->resources->get( \WC_Product::class );
	}

	/**
	 * @param array{product_id: numeric-string} $serialized_json
	 */
	public function set_from_json( array $serialized_json ): void {
		$this->resources->set( \WC_Product::class, wc_get_product( (int) $serialized_json['product_id'] ) );
	}
}
