<?php
declare(strict_types=1);

namespace WPDesk\ShopMagic\Workflow\Filter\ComparisonType;

use ShopMagicVendor\WPDesk\Forms\Field\InputTextField;
use ShopMagicVendor\WPDesk\Forms\Field\SelectField;

final class CompoundType implements ComparisonType {
	/**
	 * @var string
	 */
	public const VALUE_KEY = 'value';

	/**
	 * @var string
	 */
	public const CONDITION_KEY = 'condition';

	/** @var ComparisonType[] */
	private array $internal_types;

	/** @param ComparisonType $internal_types */
	public function __construct( ComparisonType ...$internal_types ) {
		$this->internal_types = $internal_types;
	}

	public function passed( $expected_value, string $compare_type, $actual_value ): bool {
		foreach ( $this->internal_types as $internal_type ) {
			if ( $internal_type->passed( $expected_value, $compare_type, $actual_value ) ) {
				return true;
			}
		}

		return false;
	}

	public function get_fields(): array {
		return [
			// @phpstan-ignore method.notFound
			( new SelectField() )
				->set_name( self::CONDITION_KEY )
				->set_options( $this->get_conditions() ),
			( new InputTextField() )
				->set_name( self::VALUE_KEY )
				->set_placeholder( __( 'value', 'shopmagic-for-woocommerce' ) ),
		];
	}

	public function get_conditions(): array {
		return array_reduce(
			$this->internal_types,
			static function ( array $carry, ComparisonType $type ): array {
				return array_merge( $carry, $type->get_conditions() );
			},
			[]
		);
	}
}
