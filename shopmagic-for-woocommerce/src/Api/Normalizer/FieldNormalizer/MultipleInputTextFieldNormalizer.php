<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Api\Normalizer\FieldNormalizer;

use ShopMagicVendor\WPDesk\Forms\Field\MultipleInputTextField;
use WPDesk\ShopMagic\Api\Normalizer\InvalidArgumentException;

class MultipleInputTextFieldNormalizer extends JsonSchemaFieldNormalizer {

	/**
	 * @param ActionFieldNormalizer|object $object
	 *
	 * @return array
	 */
	public function normalize( object $object ): array {
		if ( ! $this->supports_normalization( $object ) ) {
			throw InvalidArgumentException::invalid_object( MultipleInputTextField::class, $object );
		}

		return array_merge(
			parent::normalize( $object ),
			[
				'type' => 'object',
				'additionalProperties' => [
					'type' => 'string',
				],
			]
		);
	}

	public function supports_normalization( object $object ): bool {
		return $object instanceof MultipleInputTextField;
	}
}
