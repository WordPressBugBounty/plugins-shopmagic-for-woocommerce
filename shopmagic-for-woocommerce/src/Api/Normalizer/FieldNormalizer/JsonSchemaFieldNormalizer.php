<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Api\Normalizer\FieldNormalizer;

use ShopMagicVendor\WPDesk\Forms\Field;
use WPDesk\ShopMagic\Api\Normalizer\InvalidArgumentException;
use WPDesk\ShopMagic\Api\Normalizer\Normalizer;

/**
 * @implements \WPDesk\ShopMagic\Api\Normalizer\Normalizer<Field>
 */
class JsonSchemaFieldNormalizer implements Normalizer {

	public function normalize( object $object ): array {
		if ( ! $this->supports_normalization( $object ) ) {
			InvalidArgumentException::invalid_object( Field::class, $object );
		}

		$type = $this->get_type( $object );
		return array_filter(
			[
				'type'         => $this->get_type( $object ),
				'title'        => $object->get_label(),
				'description'  => $object->get_description(),
				'format'       => $type === $object->get_type() ? null : $object->get_type(),
				'default'      => $object->get_default_value(),
				'readOnly'     => $object->is_readonly(),
				'examples'     => [
					$object->get_placeholder(),
				],
				'presentation' => [
					'position' => $object->get_priority(),
				],
			],
			function ( $prop ): bool {
				if ( is_array( $prop ) ) {
					// @phpstan-ignore arrayFilter.strict
					return count( array_filter( $prop ) ) > 0;
				} elseif ( is_string( $prop ) ) {
					return strlen( $prop ) > 0;
				} elseif ( is_bool( $prop ) ) {
					return $prop;
				} else {
					return ! is_null( $prop );
				}
			}
		);
	}

	public function supports_normalization( object $object ): bool {
		return $object instanceof Field;
	}

	private function get_type( Field $object ): string {
		switch ( $object->get_type() ) {
			case 'number':
				return 'number';
			default:
				return 'string';
		}
	}
}
