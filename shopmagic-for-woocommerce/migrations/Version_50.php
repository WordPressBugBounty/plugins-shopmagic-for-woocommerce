<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\migrations;

use ShopMagicVendor\WPDesk\Migrations\AbstractMigration;

final class Version_50 extends AbstractMigration {

	public function up(): bool {
		$uploads = wp_upload_dir( null, false );
		if ( $uploads['error'] ) {
			return false;
		}

		$base = rtrim( $uploads['basedir'], '/\\' );
		$directories = [ $base ];
		foreach ( glob( $base . '/[0-9][0-9][0-9][0-9]', GLOB_ONLYDIR ) ?: [] as $year ) {
			if ( is_link( $year ) ) {
				continue;
			}
			foreach ( glob( $year . '/[0-9][0-9]', GLOB_ONLYDIR ) ?: [] as $month ) {
				if ( ! is_link( $month ) ) {
					$directories[] = $month;
				}
			}
		}

		$success = true;
		foreach ( $directories as $directory ) {
			foreach ( glob( $directory . '/shopmagic-subscribers-*.csv' ) ?: [] as $file ) {
				if ( ! preg_match( '/^shopmagic-subscribers-(?:[0-9]{14}|[0-9]{4}-[0-9]{2}-[0-9]{2})\.csv$/D', basename( $file ) ) || ! is_file( $file ) || is_link( $file ) ) {
					continue;
				}
				if ( ! unlink( $file ) ) {
					$this->logger->error( 'Cannot remove legacy subscriber export.', [ 'file' => $file ] );
					$success = false;
				}
			}
		}

		return $success;
	}
}
