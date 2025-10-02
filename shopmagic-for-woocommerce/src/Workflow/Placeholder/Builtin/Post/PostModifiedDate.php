<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Post;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\PostBasedPlaceholder;

final class PostModifiedDate extends PostBasedPlaceholder {

	public function get_slug(): string {
		return 'modified_date';
	}

	public function get_description(): string {
		return '';
	}

	public function value( array $parameters ): string {
		if ( $this->resources->has( \WP_Post::class ) ) {
			$post = $this->resources->get( \WP_Post::class );
			return get_the_modified_date( '', $post );
		}

		return '';
	}
}