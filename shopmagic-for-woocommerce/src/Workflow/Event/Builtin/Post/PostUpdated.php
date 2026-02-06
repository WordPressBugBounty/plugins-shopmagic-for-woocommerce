<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin\Post;

use WPDesk\ShopMagic\FormField\Field\SelectField;
use WPDesk\ShopMagic\Workflow\Event\Builtin\PostCommonEvent;
use WP_Post;

final class PostUpdated extends PostCommonEvent {

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
		if ( ! $this->matches_post_type( $post_after, self::PARAM_POST_TYPE ) ) {
			return;
		}
		$this->trigger_automation();
	}

	public function get_name(): string {
		return esc_html__( 'Post updated', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return esc_html__( 'Run automation when a post is updated. Any change in post (content, title, slug) triggers this automation.', 'shopmagic-for-woocommerce' );
	}

	/**
	 * @return \ShopMagicVendor\WPDesk\Forms\Field[]
	 */
	public function get_fields(): array {
		return [
			( new SelectField() )
				->set_label( esc_html__( 'Post type', 'shopmagic-for-woocommerce' ) )
				->set_name( self::PARAM_POST_TYPE )
				->set_options( $this->get_post_type_options() )
				->set_default_value( 'post' ),
		];
	}

}
