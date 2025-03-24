<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Api\Normalizer\FieldNormalizer;

use WPDesk\ShopMagic\Admin\Form\FieldsCollection;
use WPDesk\ShopMagic\Api\Normalizer\InvalidArgumentException;
use WPDesk\ShopMagic\Api\Normalizer\Normalizer;
use WPDesk\ShopMagic\Api\Normalizer\NormalizerCollection;

/**
 * @implements Normalizer<FieldsCollection>
 */
class JsonSchemaNormalizer implements Normalizer {

	/** @var NormalizerCollection */
	private $normalizers;

	public function __construct( NormalizerCollection $normalizer ) {
		$this->normalizers = $normalizer;
	}

	public function normalize( object $object ): array {
		if ( ! $this->supports_normalization( $object ) ) {
			throw InvalidArgumentException::invalid_object( FieldsCollection::class, $object );
		}

		$properties = array_map(
			function ( $field ) {
				if ( $this->supports_normalization( $field ) ) {
					return $this->normalize( $field );
				}

				return $this->normalizers->normalize( $field );
			},
			$object->get_fields()
		);

		if ( empty( $properties ) ) {
			return [
				'type' => 'null',
			];
		}

		return [
			'type'         => 'object',
			'properties'   => $properties,
			'required'     => array_keys( $object->get_required_fields() ),
			'presentation' => [
				'position' => $object->get_priority(),
			],
		];
	}

	public function supports_normalization( object $object ): bool {
		return $object instanceof FieldsCollection;
	}
}
