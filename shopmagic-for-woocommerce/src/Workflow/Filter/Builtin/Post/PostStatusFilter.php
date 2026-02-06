<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Filter\Builtin\Post;

use WPDesk\ShopMagic\Workflow\Filter\Builtin\PostFilter;
use WPDesk\ShopMagic\Workflow\Filter\ComparisonType\ComparisonType;
use WPDesk\ShopMagic\Workflow\Filter\ComparisonType\SelectOneToManyType;

final class PostStatusFilter extends PostFilter {

	public function get_id(): string {
		return 'post_status';
	}

	public function get_name(): string {
		return esc_html__( 'Post - Status', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return esc_html__( 'Run automation only if the post status matches the selected rule.', 'shopmagic-for-woocommerce' );
	}

	public function passed(): bool {
		$type = $this->get_type();

		return $type->passed(
			(array) $this->fields_data->get( SelectOneToManyType::VALUE_KEY ),
			(string) $this->fields_data->get( SelectOneToManyType::CONDITION_KEY ),
			$this->get_post()->post_status
		);
	}

	protected function get_type(): ComparisonType {
		return new SelectOneToManyType( $this->get_status_options() );
	}

	/**
	 * @return array<string, string>
	 */
	private function get_status_options(): array {
		$statuses = get_post_stati( [], 'objects' );
		$options  = [];

		foreach ( $statuses as $slug => $status_object ) {
			$options[ $slug ] = $status_object->label ?? $slug;
		}

		return $options;
	}
}
