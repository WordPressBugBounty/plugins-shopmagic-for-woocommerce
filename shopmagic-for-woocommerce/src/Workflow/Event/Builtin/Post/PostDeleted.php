<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin\Post;

use WPDesk\ShopMagic\FormField\Field\SelectField;
use WPDesk\ShopMagic\Workflow\Event\Builtin\PostCommonEvent;

final class PostDeleted extends PostCommonEvent {

	public function get_id(): string {
		return 'shopmagic_post_deleted';
	}

	public function get_name(): string {
		return esc_html__( 'Post deleted', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return esc_html__( 'Run automation when a post is moved to trash or permanently deleted.', 'shopmagic-for-woocommerce' );
	}

	public function initialize(): void {
		add_action(
			'wp_trash_post',
			function ( int $post_id ): void {
				$this->handle_post_deletion( $post_id );
			}
		);
		add_action(
			'before_delete_post',
			function ( int $post_id ): void {
				$this->handle_post_deletion( $post_id );
			}
		);
	}

	public function get_fields(): array {
		return [
			( new SelectField() )
				->set_label( esc_html__( 'Post type', 'shopmagic-for-woocommerce' ) )
				->set_name( self::PARAM_POST_TYPE )
				->set_options( $this->get_post_type_options() )
				->set_default_value( 'post' ),
		];
	}

	private function handle_post_deletion( int $post_id ): void {
		$post = get_post( $post_id );
		if ( ! $post instanceof \WP_Post ) {
			return;
		}

		$this->resources->set( \WP_Post::class, $post );

		if ( ! $this->matches_post_type( $post, self::PARAM_POST_TYPE ) ) {
			return;
		}

		$this->trigger_automation();
	}
}
