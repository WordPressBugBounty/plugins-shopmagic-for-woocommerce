<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Autoresponders\DeleteAutoresponder;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class DeleteAutoresponder extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/autoresponders/{autoresponderId}';
    /** @var string */
    private $autoresponderId;
    /**
     * @param string $autoresponderId
     */
    public function __construct($autoresponderId)
    {
        $this->autoresponderId = $autoresponderId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{autoresponderId}'], [$this->autoresponderId], self::METHOD_URL);
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->buildUrlFromTemplate();
    }
    /**
     * @return string
     */
    public function getMethod()
    {
        return Operation::DELETE;
    }
    /**
     * @return string
     */
    public function getBody()
    {
        return '';
    }
    /**
     * @return int
     */
    public function getSuccessCode()
    {
        return 204;
    }
}
