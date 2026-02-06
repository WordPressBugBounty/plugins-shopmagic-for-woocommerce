<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin;

use WPDesk\ShopMagic\Workflow\Components\Groups;
use WPDesk\ShopMagic\Workflow\Event\Event;

abstract class PostCommonEvent extends Event {

	/** @var string */
	protected const PARAM_POST_TYPE = 'post_type';

	public function get_group_slug(): string {
		return Groups::POST;
	}

	public function get_provided_data_domains(): array {
		return array_merge(
			parent::get_provided_data_domains(),
			[ \WP_Post::class ]
		);
	}

	/**
	 * @return array{post_id: numeric-string|int} Normalized event data required for Queue serialization.
	 */
	public function jsonSerialize(): array {
		return [
			'post_id' => $this->get_post()->ID,
		];
	}

	private function get_post(): \WP_Post {
		return $this->resources->get( \WP_Post::class );
	}

	/**
	 * @param array{post_id: numeric-string} $serialized_json
	 */
	public function set_from_json( array $serialized_json ): void {
		$this->resources->set( \WP_Post::class, get_post( (int) $serialized_json['post_id'] ) );
	}

	/**
	 * @return array<string, string>
	 */
	protected function get_post_type_options(): array {
		$options = [
			'post' => esc_html__( 'Post', 'shopmagic-for-woocommerce' ),
			'page' => esc_html__( 'Page', 'shopmagic-for-woocommerce' ),
		];

		$custom_types = $this->get_allowed_post_types();
		foreach ( $custom_types as $type ) {
			$post_type_object = get_post_type_object( $type );
			if ( $post_type_object ) {
				$options[ $type ] = $post_type_object->labels->singular_name;
			}
		}

		return $options;
	}

	/**
	 * @return string[]
	 */
	protected function get_allowed_post_types(): array {
		$all_types      = get_post_types( [ 'public' => true ], 'names' );
		$excluded_types = [
			'product',
			'product_variation',
			'shop_order',
			'shop_coupon',
			'shop_subscription',
			'attachment',
		];

		return array_diff( $all_types, $excluded_types, [ 'post', 'page' ] );
	}

	protected function matches_post_type( \WP_Post $post, string $parameter = 'post_type', string $default = 'post' ): bool {
		$selected_post_type = $this->fields_data->has( $parameter )
			? (string) $this->fields_data->get( $parameter )
			: $default;

		return $post->post_type === $selected_post_type;
	}
}
