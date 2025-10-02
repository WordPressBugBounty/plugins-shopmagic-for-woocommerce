<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin\Post;

use WPDesk\ShopMagic\Workflow\Event\Builtin\PostCommonEvent;
use WPDesk\ShopMagic\FormField\Field\SelectField;


final class PostPublished extends PostCommonEvent {

	/** @var string */
	private const PARAM_POST_TYPE = 'post_type';
	public function get_id(): string {
		return 'shopmagic_post_published';
	}

	public function get_name(): string {
		return __( 'Post Published', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return __(
			'Run automation when a post is published. Runs every time, post changes from draft to published.',
			'shopmagic-for-woocommerce'
		);
	}

	public function initialize(): void {
		add_action(
			'transition_post_status',
			function ( string $new_status, string $old_status, \WP_Post $post ) {
				$this->process_event( $new_status, $old_status, $post );
			},
			10,
			3
		);
	}

	public function process_event( string $new_status, string $old_status, \WP_Post $post ): void {
		$this->resources->set( \WP_Post::class, $post );
		if ( 'publish' !== $new_status ) {
			return;
		}
		if ( 'publish' === $old_status ) {
			return;
		}
		$selected_post_type = $this->fields_data->get( self::PARAM_POST_TYPE );
		if ( $post->post_type !== $selected_post_type ) {
			return;
		}
		$this->trigger_automation();
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
