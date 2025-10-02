<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin\Post;

use WPDesk\ShopMagic\FormField\Field\SelectField;

final class PostUpdated extends \WPDesk\ShopMagic\Workflow\Event\Builtin\PostCommonEvent {

	/** @var string */
	private const PARAM_POST_TYPE = 'post_type';
	public function get_id(): string {
		return 'shopmagic_post_updated';
	}

	public function initialize(): void {
		add_action(
			'post_updated',
			function ( int $_, \WP_Post $post_after ): void {
				$this->on_post_updated( $post_after );
			},
			10,
			2
		);
	}

	public function on_post_updated( \WP_Post $post_after ): void {
		$this->resources->set( \WP_Post::class, $post_after );
		$selected_post_type = $this->fields_data->get( self::PARAM_POST_TYPE );
		if ( $post_after->post_type !== $selected_post_type ) {
			return;
		}
		$this->trigger_automation();
	}

	public function get_name(): string {
		return esc_html__( 'Post updated', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return __( 'Run automation when a post is updated. Any change in post (content, title, slug) triggers this automation.', 'shopmagic-for-woocommerce' );
	}

	/**
	 * @return \ShopMagicVendor\WPDesk\Forms\Field[]
	 */
	public function get_fields(): array {
		return [
			( new SelectField() )
				->set_label( __( 'Post type', 'shopmagic-for-woocommerce' ) )
				->set_name( self::PARAM_POST_TYPE )
				->set_options( $this->get_post_type_options() )
				->set_default_value( 'post' ),
		];
	}

	/**
	 * @return array<string, string>
	 */
	private function get_post_type_options(): array {
		$options = [
			'post' => __( 'Post', 'shopmagic-for-woocommerce' ),
			'page' => __( 'Page', 'shopmagic-for-woocommerce' ),
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
	private function get_allowed_post_types(): array {
		$all_types = get_post_types( [ 'public' => true ], 'names' );
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
}
