<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPDesk\ShopMagic\Helper;

/**
 * ParameterBag is a container for key/value pairs.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @implements \IteratorAggregate<string, mixed>
 */
class ParameterBag implements \IteratorAggregate, \Countable {

	/**
	 * Parameter storage.
	 *
	 * @var array<string, mixed>
	 */
	protected $parameters;

	public function __construct( array $parameters = [] ) {
		$this->parameters = $parameters;
	}

	/**
	 * Returns the parameters.
	 *
	 * @param string|null $key The name of the parameter to return or null to get them all
	 */
	public function all( string $key = null ): array {
		if ( null === $key ) {
			return $this->parameters;
		}

		if ( ! \is_array( $value = $this->parameters[ $key ] ?? [] ) ) {
			throw new \RuntimeException( sprintf( 'Unexpected value for parameter "%s": expecting "array", got "%s".', $key, get_debug_type( $value ) ) );
		}

		return $value;
	}

	/**
	 * Returns the parameter keys.
	 */
	public function keys(): array {
		return array_keys( $this->parameters );
	}

	/**
	 * Replaces the current parameters by a new set.
	 *
	 * @return void
	 */
	public function replace( array $parameters = [] ) {
		$this->parameters = $parameters;
	}

	/**
	 * Adds parameters.
	 *
	 * @return void
	 */
	public function add( array $parameters = [] ) {
		$this->parameters = array_replace( $this->parameters, $parameters );
	}

	/**
	 * @param string $key We cannot typehint this parameter as we need to keep compatibility with
	 *                    ContainerInterface::has() required by FieldValuesBag.
	 * @param mixed  $default
	 *
	 * @return mixed|null
	 * @TODO: add parameter typehint in 4.0.0
	 */
	public function get( $key, $default = null ) {
		return \array_key_exists( $key, $this->parameters ) ? $this->parameters[ $key ] : $default;
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function set( string $key, $value ) {
		$this->parameters[ $key ] = $value;
	}

	/**
	 * Returns true if the parameter is defined.
	 *
	 * @param string $key We cannot typehint this parameter as we need to keep compatibility with
	 *                    ContainerInterface::has() required by FieldValuesBag.
	 *
	 * @TODO: add parameter typehint in 4.0.0
	 */
	public function has( $key ): bool {
		return \array_key_exists( $key, $this->parameters );
	}

	/**
	 * Removes a parameter.
	 *
	 * @return void
	 */
	public function remove( string $key ) {
		unset( $this->parameters[ $key ] );
	}

	/**
	 * Returns the alphabetic characters of the parameter value.
	 */
	public function getAlpha( string $key, string $default = '' ): string {
		return preg_replace( '/[^[:alpha:]]/', '', $this->get( $key, $default ) );
	}

	/**
	 * Returns the alphabetic characters and digits of the parameter value.
	 */
	public function getAlnum( string $key, string $default = '' ): string {
		return preg_replace( '/[^[:alnum:]]/', '', $this->get( $key, $default ) );
	}

	/**
	 * Returns the digits of the parameter value.
	 */
	public function getDigits( string $key, string $default = '' ): string {
		// we need to remove - and + because they're allowed in the filter
		return str_replace(
			[
				'-',
				'+',
			],
			'',
			$this->filter( $key, $default, \FILTER_SANITIZE_NUMBER_INT )
		);
	}

	/**
	 * Returns the parameter value converted to integer.
	 */
	public function getInt( string $key, int $default = 0 ): int {
		return (int) $this->get( $key, $default );
	}

	/**
	 * Returns the parameter value converted to boolean.
	 */
	public function getBoolean( string $key, bool $default = false ): bool {
		return $this->filter( $key, $default, \FILTER_VALIDATE_BOOLEAN );
	}

	/**
	 * Filter key.
	 *
	 * @param int $filter FILTER_* constant
	 *
	 * @see https://php.net/filter-var
	 */
	public function filter( string $key, $default = null, int $filter = \FILTER_DEFAULT, $options = [] ) {
		$value = $this->get( $key, $default );

		// Always turn $options into an array - this allows filter_var option shortcuts.
		if ( ! \is_array( $options ) && $options ) {
			$options = [ 'flags' => $options ];
		}

		// Add a convenience check for arrays.
		if ( \is_array( $value ) && ! isset( $options['flags'] ) ) {
			$options['flags'] = \FILTER_REQUIRE_ARRAY;
		}

		if ( ( \FILTER_CALLBACK & $filter ) && ! ( ( $options['options'] ?? null ) instanceof \Closure ) ) {
			throw new \InvalidArgumentException( sprintf( 'A Closure must be passed to "%s()" when FILTER_CALLBACK is used, "%s" given.', __METHOD__, get_debug_type( $options['options'] ?? null ) ) );
		}

		return filter_var( $value, $filter, $options );
	}

	/**
	 * Returns an iterator for parameters.
	 *
	 * @return \ArrayIterator<string, mixed>
	 */
	public function getIterator(): \ArrayIterator {
		return new \ArrayIterator( $this->parameters );
	}

	/**
	 * Returns the number of parameters.
	 */
	public function count(): int {
		return \count( $this->parameters );
	}
}
