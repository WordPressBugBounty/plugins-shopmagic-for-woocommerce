<?php

namespace WPDesk\ShopMagic\Integration\MailerLite;

use ShopMagicVendor\MailerLite\MailerLite;

final class APITools {

	private const STATUS_CODE         = 'status_code';
	private const STATUS_CODE_OK      = 200;
	private const STATUS_CODE_CREATED = 201;

	private MailerLite $mailerLite;

	public function __construct( MailerLite $mailerLite ) {
		$this->mailerLite = $mailerLite;
	}

	public function get_groups(): array {
		$response = $this->mailerLite->groups->get();

		$result = [];

		foreach ( $response['body']['data'] as $group ) {
			// Prefixed due to incorrect parsing by Frontend.
			$result[ 'id_' . $group['id'] ] = $group['name'];
		}

		return $result;
	}

	public function create_subscriber( array $data ): bool {
		$response = $this->mailerLite->subscribers->create( $data );

		return $response[ self::STATUS_CODE ] === self::STATUS_CODE_OK || $response[ self::STATUS_CODE ] === self::STATUS_CODE_CREATED;
	}
}
