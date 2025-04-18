<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Components\Routing\Controller\ArgumentResolver;

class RawRequestValueResolver implements \WPDesk\ShopMagic\Components\Routing\Controller\ArgumentValueResolver {

	public function supports( \WP_REST_Request $request, \ReflectionParameter $parameter ): bool {
		return isset( $_REQUEST[ $parameter->getName() ] );
	}

	public function resolve( \WP_REST_Request $request, \ReflectionParameter $parameter ) {
		$value = isset( $_REQUEST[ $parameter->getName() ] ) ? wp_unslash( $_REQUEST[ $parameter->getName() ] ) : null; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitization must be handled by controller.

		if ( $value === null ) {
			return null;
		} elseif ( $parameter->hasType() ) {
			settype( $value, $parameter->getType()->getName() );

			return $value;
		} else {
			return $value;
		}
	}
}
