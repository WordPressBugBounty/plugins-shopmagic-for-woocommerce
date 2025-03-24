<?php

namespace WPDesk\ShopMagic\Integration\ActiveCampaign;

final class ActiveCampaign {

	private string $api_key;

	private string $api_endpoint;

	private const API_ENDPOINT = '<api_url>/api/3/';
	private const METHOD_GET   = 'GET';
	private const METHOD_POST  = 'POST';

	public function __construct( string $api_key, string $api_url ) {
		$this->api_key      = $api_key;
		$this->api_endpoint = str_replace( '<api_url>', $api_url, self::API_ENDPOINT );
	}

	public function add_contact( array $contact ): bool {
		$response = $this->post( 'contacts', [ 'contact' => $contact ] );

		return $response['status'] === 201;
	}

	private function post( string $endpoint, array $params = [] ): array {
		return $this->make_request( self::METHOD_POST, $endpoint, $params );
	}

	private function make_request( string $method, string $endpoint, array $params ): array {
		$url     = $this->api_endpoint . $endpoint;
		$headers = [
			'Api-Token'    => $this->api_key,
			'Accept'       => 'application/json',
			'Content-Type' => 'application/json',
		];

		switch ( $method ) {
			case self::METHOD_GET:
				if ( ! empty( $params ) ) {
					$url = add_query_arg( $params, $url );
				}
				$response = wp_remote_get( $url, [ 'headers' => $headers ] );
				break;

			case self::METHOD_POST:
				$body     = ! empty( $params ) ? wp_json_encode( $params ) : '';
				$response = wp_remote_post(
					$url,
					[
						'headers' => $headers,
						'body'    => $body,
					]
				);
				break;

			default:
				throw new \Exception(
					sprintf( 'HTTP method "%s" not supported.', $method )
				);
		}

		if ( is_wp_error( $response ) ) {
			throw new \Exception(
				sprintf( 'ActiveCampaign request error: %s', $response->get_error_message() )
			);
		}

		return [
			'status' => $response['response']['code'],
			'body'   => json_decode( wp_remote_retrieve_body( $response ) ),
		];
	}
}
