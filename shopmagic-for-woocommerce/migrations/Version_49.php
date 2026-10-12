<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\migrations;

use ShopMagicVendor\WPDesk\Migrations\AbstractMigration;
use WPDesk\ShopMagic\Database\DatabaseTable;

final class Version_49 extends AbstractMigration {

	public function up(): bool {
		$table_name = DatabaseTable::automation_outcome();
		$index_sql  = $this->wpdb->prepare(
			"SHOW INDEX FROM %i WHERE Key_name = 'automation_metrics'",
			$table_name
		);
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$index = $this->wpdb->get_var( $index_sql );

		if ( $index !== null ) {
			return true;
		}

		$migration_sql = $this->wpdb->prepare(
			'ALTER TABLE %i
			ADD INDEX automation_metrics (automation_id, finished, updated)',
			$table_name
		);
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		return (bool) $this->wpdb->query( $migration_sql );
	}
}
