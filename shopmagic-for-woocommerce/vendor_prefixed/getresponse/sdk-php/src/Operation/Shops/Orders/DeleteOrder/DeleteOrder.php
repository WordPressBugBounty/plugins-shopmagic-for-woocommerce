<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Shops\Orders\DeleteOrder;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class DeleteOrder extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/shops/{shopId}/orders/{orderId}';
    /** @var string */
    private $shopId;
    /** @var string */
    private $orderId;
    /**
     * @param string $shopId
     * @param string $orderId
     */
    public function __construct($shopId, $orderId)
    {
        $this->shopId = $shopId;
        $this->orderId = $orderId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{shopId}', '{orderId}'], [$this->shopId, $this->orderId], self::METHOD_URL);
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
