<?php
declare(strict_types=1);

namespace WPDesk\ShopMagic\Tracker;

use WPDesk\ShopMagic\Components\HookProvider\HookProvider;

/**
 * Tracks data about usages.
 */
class UsageDataTracker implements HookProvider {

	/** @var array<\WPDesk_Tracker_Data_Provider> */
	private $providers;

	/**
	 * @param array<\WPDesk_Tracker_Data_Provider> $providers
	 */
	public function __construct( array $providers = [] ) {
		$this->providers = $providers;
	}

	/**
	 * @note Used by DI container
	 *
	 * @param array $providers
	 *
	 * @return void
	 */
	public function set_providers( array $providers ): void {
		$this->providers = $providers;
	}

	public function hooks(): void {
		add_filter( 'wpdesk_tracker_data', [ $this, 'append_usage_data' ] );
		add_filter(
			'wpdesk_tracker_enabled',
			static function () {
				return true;
			}
		);
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function append_usage_data( array $data ): array {
		foreach ( $this->providers as $provider ) {
			$data = array_merge( $data, $provider->get_data() );
		}

		return $data;
	}
}
