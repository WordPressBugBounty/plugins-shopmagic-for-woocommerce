<?php
declare(strict_types=1);

namespace WPDesk\ShopMagic\Workflow\Filter\Builtin\Customer;

use WPDesk\ShopMagic\Workflow\Filter\Builtin\CustomerFilter;
use WPDesk\ShopMagic\Workflow\Filter\ComparisonType\ComparisonType;
use WPDesk\ShopMagic\Workflow\Filter\ComparisonType\CompoundType;
use WPDesk\ShopMagic\Workflow\Filter\ComparisonType\IntegerType;
use WPDesk\ShopMagic\Workflow\Filter\ComparisonType\StringArrayType;


final class CustomerIdFilter extends CustomerFilter {
	public function get_id(): string {
		return 'customer_id';
	}

	public function get_name(): string {
		return __( 'Customer - ID', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return esc_html__( 'Run automation if customer ID matches the rule.', 'shopmagic-for-woocommerce' );
	}

	public function passed(): bool {
		if ( $this->get_customer()->is_guest() ) {
			return false;
		}

		return $this->get_type()->passed(
			$this->fields_data->get( IntegerType::VALUE_KEY ),
			$this->fields_data->get( IntegerType::CONDITION_KEY ),
			(int) $this->get_customer()->get_id()
		);
	}

	protected function get_type(): ComparisonType {
		return new CompoundType( new IntegerType(), new StringArrayType() );
	}
}
