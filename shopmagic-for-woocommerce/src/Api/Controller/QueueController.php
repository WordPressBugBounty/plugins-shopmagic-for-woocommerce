<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Api\Controller;

use WPDesk\ShopMagic\Components\Collections\ArrayCollection;
use WPDesk\ShopMagic\Components\Routing\HttpProblemException;
use WPDesk\ShopMagic\Customer\Customer;
use WPDesk\ShopMagic\Workflow\Automation\Automation;
use WPDesk\ShopMagic\Workflow\Automation\AutomationRepository;
use WPDesk\ShopMagic\Workflow\Queue\ActionSchedulerQueue;
use WPDesk\ShopMagic\Workflow\Queue\Queue;

class QueueController {

	/** @var Queue */
	private $queue;

	public function __construct( Queue $queue ) {
		$this->queue = $queue;
	}

	public function index(
		\WP_REST_Request $request,
		AutomationRepository $repository,
		\wpdb $wpdb
	): \WP_REST_Response {
		$search = $this->pending_actions( $request, $wpdb );

		$queue_collection = new ArrayCollection( $search );

		return new \WP_REST_Response(
			$queue_collection->map(
				function ( $queue_action, int $index ) use ( $repository ) {
					if ( is_array( $queue_action ) ) {
						$args     = json_decode( $queue_action['args'], true );
						$schedule = ( new \DateTimeImmutable( $queue_action['scheduled_date_gmt'], new \DateTimeZone( 'UTC' ) ) )
							->setTimezone( wp_timezone() )
							->format( \DateTimeInterface::ATOM );
					} else {
						$args     = $queue_action->get_args();
						$schedule = $queue_action->get_schedule();
						if ( $schedule instanceof \ActionScheduler_Abstract_Schedule ) {
							$schedule = $schedule->get_date()->setTimezone( wp_timezone() )->format( \DateTimeInterface::ATOM );
						} else {
							$schedule = null;
						}
					}
					[
						$automation_data,
						$event_params,
						, // Unused serialized action.
						$action_index,
						$execution_id,
					] = $args;

					$customer   = null;
					$automation = null;

					try {
						$automation = $repository->find( $automation_data['id'] );

						$event = $automation->get_event();
						$event->set_from_json( $event_params );
						$data = $event->get_provided_data();
						if ( $data->has( Customer::class ) ) {
							$customer = $data->get( Customer::class );
						}
					} catch ( \Throwable $e ) {
					}

					return [
						'id'           => $index,
						'execution_id' => $execution_id ?? $index,
						'automation'   => $automation ? $this->normalize_automation( $automation, $action_index ) : null,
						'customer'     => $customer ? $this->normalize_customer( $customer ) : null,
						'schedule'     => $schedule,
					];
				}
			)->to_array()
		);
	}

	/**
	 * @return array{id: string, guest: bool, email: string}
	 */
	private function normalize_customer( Customer $customer ): array {
		return [
			'id'    => $customer->get_id(),
			'guest' => $customer->is_guest(),
			'email' => $customer->get_email(),
		];
	}

	/**
	 * @return array{id: string, name: string, actions: string[]}
	 */
	private function normalize_automation( Automation $automation, int $action_index ): array {
		return [
			'id'      => $automation->get_id(),
			'name'    => $automation->get_name(),
			'actions' => [
				$action_index => $automation->has_action( $action_index ) ? $automation->get_action( $action_index )->get_name() : null,
			],
		];
	}

	public function count( \WP_REST_Request $request, \wpdb $wpdb ): \WP_REST_Response {
		$filters = $request->get_param( 'filters' );
		if ( isset( $filters['automation'] ) && is_numeric( $filters['automation'] ) ) {
			return new \WP_REST_Response( $this->count_pending_actions( (int) $filters['automation'], $wpdb ) );
		}

		$count = \ActionScheduler::store()->query_actions(
			[
				'group'    => ActionSchedulerQueue::GROUP,
				'status'   => \ActionScheduler_Store::STATUS_PENDING,
				'per_page' => - 1,
			],
			'count'
		);

		return new \WP_REST_Response( $count );
	}

	/**
	 * @return array<int, object|array{args: string, scheduled_date_gmt: string}>
	 */
	private function pending_actions( \WP_REST_Request $request, \wpdb $wpdb ): array {
		$filters       = $request->get_param( 'filters' );
		$automation_id = isset( $filters['automation'] ) && is_numeric( $filters['automation'] )
			? (int) $filters['automation']
			: null;

		if ( $automation_id !== null ) {
			return $this->pending_action_rows( $automation_id, $request, $wpdb );
		}

		return $this->queue->search(
			[
				'group'    => ActionSchedulerQueue::GROUP,
				'status'   => \ActionScheduler_Store::STATUS_PENDING,
				'per_page' => $request->get_param( 'pageSize' ),
				'offset'   => ( $request->get_param( 'page' ) - 1 ) * $request->get_param( 'pageSize' ),
			]
		);
	}

	/**
	 * @return array<int, array{args: string, scheduled_date_gmt: string}>
	 */
	private function pending_action_rows( int $automation_id, \WP_REST_Request $request, \wpdb $wpdb ): array {
		$page_size = (int) $request->get_param( 'pageSize' );
		$offset    = ( (int) $request->get_param( 'page' ) - 1 ) * $page_size;
		$sql       = $this->prepare_filtered_actions_query(
			"SELECT a.action_id, COALESCE(NULLIF(a.extended_args, ''), a.args) AS args, a.scheduled_date_gmt",
			$automation_id,
			$wpdb,
			' ORDER BY a.scheduled_date_gmt ASC LIMIT %d, %d',
			$offset,
			$page_size
		);

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$rows = $wpdb->get_results( $sql, ARRAY_A );

		$actions = [];
		foreach ( $rows as $row ) {
			$action_id = (int) $row['action_id'];
			unset( $row['action_id'] );
			$actions[ $action_id ] = $row;
		}

		return $actions;
	}

	private function count_pending_actions( int $automation_id, \wpdb $wpdb ): int {
		$sql = $this->prepare_filtered_actions_query( 'SELECT COUNT(*)', $automation_id, $wpdb );

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		return (int) $wpdb->get_var( $sql );
	}

	private function prepare_filtered_actions_query(
		string $select,
		int $automation_id,
		\wpdb $wpdb,
		string $suffix = '',
		int ...$suffix_params
	): string {
		$actions_table = $wpdb->prefix . 'actionscheduler_actions';
		$groups_table  = $wpdb->prefix . 'actionscheduler_groups';
		$args_column   = "COALESCE(NULLIF(a.extended_args, ''), a.args)";
		$args_pattern  = $wpdb->esc_like( sprintf( '[{"id":%d},', $automation_id ) ) . '%';

		// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQLPlaceholders.UnfinishedPrepare
		$sql = $wpdb->prepare(
			"{$select}
			FROM %i a
			INNER JOIN %i g ON g.group_id = a.group_id
			WHERE a.status = %s AND g.slug = %s AND {$args_column} LIKE %s{$suffix}",
			$actions_table,
			$groups_table,
			'pending',
			ActionSchedulerQueue::GROUP,
			$args_pattern,
			...$suffix_params
		);
		// phpcs:enable

		return $sql;
	}

	public function cancel( int $id ): \WP_REST_Response {
		$action = \ActionScheduler::store()->fetch_action( $id );
		if ( $action->get_group() !== ActionSchedulerQueue::GROUP ) {
			throw new HttpProblemException(
				[
					'title' => esc_html__( 'Cannot cancel action outside ShopMagic group.', 'shopmagic-for-woocommerce' ),
				]
			);
		}

		$this->queue->cancel( $id );

		return new \WP_REST_Response( null, \WP_Http::NO_CONTENT );
	}
}
