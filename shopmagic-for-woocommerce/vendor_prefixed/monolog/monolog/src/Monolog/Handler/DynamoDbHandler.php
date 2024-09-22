<?php

declare (strict_types=1);
/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ShopMagicVendor\Monolog\Handler;

use ShopMagicVendor\Aws\Sdk;
use ShopMagicVendor\Aws\DynamoDb\DynamoDbClient;
use ShopMagicVendor\Monolog\Formatter\FormatterInterface;
use ShopMagicVendor\Aws\DynamoDb\Marshaler;
use ShopMagicVendor\Monolog\Formatter\ScalarFormatter;
use ShopMagicVendor\Monolog\Logger;
/**
 * Amazon DynamoDB handler (http://aws.amazon.com/dynamodb/)
 *
 * @link https://github.com/aws/aws-sdk-php/
 * @author Andrew Lawson <adlawson@gmail.com>
 */
class DynamoDbHandler extends AbstractProcessingHandler
{
    public const DATE_FORMAT = 'Y-m-d\TH:i:s.uO';
    /**
     * @var DynamoDbClient
     */
    protected $client;
    /**
     * @var string
     */
    protected $table;
    /**
     * @var int
     */
    protected $version;
    /**
     * @var Marshaler
     */
    protected $marshaler;
    public function __construct(DynamoDbClient $client, string $table, $level = Logger::DEBUG, bool $bubble = \true)
    {
        /** @phpstan-ignore-next-line */
        if (defined('ShopMagicVendor\Aws\Sdk::VERSION') && version_compare(Sdk::VERSION, '3.0', '>=')) {
            $this->version = 3;
            $this->marshaler = new Marshaler();
        } else {
            $this->version = 2;
        }
        $this->client = $client;
        $this->table = $table;
        parent::__construct($level, $bubble);
    }
    /**
     * {@inheritDoc}
     */
    protected function write(array $record): void
    {
        $filtered = $this->filterEmptyFields($record['formatted']);
        if ($this->version === 3) {
            $formatted = $this->marshaler->marshalItem($filtered);
        } else {
            /** @phpstan-ignore-next-line */
            $formatted = $this->client->formatAttributes($filtered);
        }
        $this->client->putItem(['TableName' => $this->table, 'Item' => $formatted]);
    }
    /**
     * @param  mixed[] $record
     * @return mixed[]
     */
    protected function filterEmptyFields(array $record): array
    {
        return array_filter($record, function ($value) {
            return !empty($value) || \false === $value || 0 === $value;
        });
    }
    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new ScalarFormatter(self::DATE_FORMAT);
    }
}