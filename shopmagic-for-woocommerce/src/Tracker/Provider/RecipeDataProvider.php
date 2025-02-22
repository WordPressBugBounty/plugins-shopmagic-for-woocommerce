<?php
declare(strict_types=1);

namespace WPDesk\ShopMagic\Tracker\Provider;

/**
 * Provides info about recipe usage.
 */
class RecipeDataProvider implements \WPDesk_Tracker_Data_Provider {
	public function get_data(): array {
		global $wpdb;

		$meta_name = 'shopmagic_source_recipe';

		$results = $wpdb->get_results(
			"
			SELECT
			    meta_value as v,
				COUNT(*) as c
			FROM
				{$wpdb->postmeta}
			WHERE
				meta_key = '{$meta_name}'
			GROUP BY
				meta_value",
			ARRAY_A
		);
		$recipes = [];
		foreach ( $results as $result ) {
			$recipes[ $result['v'] ] = $result['c'];
		}

		return [
			'shopmagic_recipes' => $recipes,
		];
	}
}
