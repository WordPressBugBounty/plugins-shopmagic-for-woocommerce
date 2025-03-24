<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Api\Normalizer\FieldNormalizer;

use ShopMagicVendor\WPDesk\Forms\Field\SelectField;
use WPDesk\ShopMagic\Admin\Form\Fields\MultipleCheckboxField;
use WPDesk\ShopMagic\Api\Normalizer\InvalidArgumentException;

class MultipleSelectFieldNormalizer extends JsonSchemaFieldNormalizer {

	public function normalize( object $object ): array {
		if ( ! $this->supports_normalization( $object ) ) {
			throw InvalidArgumentException::invalid_object( SelectField::class, $object );
		}

		$options = array_map(
			static function ( $value, $label ) {
				return [
					'const' => $value,
					'title' => $label,
				];
			},
			array_keys( $object->get_possible_values() ),
			array_values( $object->get_possible_values() )
		);

		return array_merge(
			parent::normalize( $object ),
			[
				'type'        => 'array',
				'items'       => [
					'anyOf' => array_merge( $options, [ [ 'type' => 'null' ], [ 'type' => 'string' ] ] ),
				],
				'uniqueItems' => true,
				'format'      => $object instanceof SelectField ? 'select' : 'checkbox',
			]
		);
	}

	public function supports_normalization( object $object ): bool {
		return ( $object instanceof SelectField && $object->is_multiple() ) ||
				$object instanceof MultipleCheckboxField;
	}
}
