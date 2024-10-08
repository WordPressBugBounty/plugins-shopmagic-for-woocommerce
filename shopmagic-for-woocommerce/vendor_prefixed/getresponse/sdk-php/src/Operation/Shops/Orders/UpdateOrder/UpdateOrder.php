<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Shops\Orders\UpdateOrder;

use ShopMagicVendor\Getresponse\Sdk\Client\Exception\InvalidCommandDataException;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
use ShopMagicVendor\Getresponse\Sdk\Operation\Model\UpdateOrder as ModelUpdateOrder;
class UpdateOrder extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/shops/{shopId}/orders/{orderId}';
    /** @var ModelUpdateOrder */
    protected $data;
    /** @var string */
    private $shopId;
    /** @var string */
    private $orderId;
    /** @var UpdateOrderAdditionalFlags */
    private $additionalFlags;
    /**
     * @param ModelUpdateOrder $data
     * @param string $shopId
     * @param string $orderId
     */
    public function __construct(ModelUpdateOrder $data, $shopId, $orderId)
    {
        $this->data = $data;
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
        $extra = $this->getAdditionalFlagsParameterArray($this->additionalFlags);
        return $this->buildUrlFromTemplate() . $this->buildUrlQuery(null, $extra);
    }
    /**
     * @return string
     */
    public function getMethod()
    {
        return Operation::POST;
    }
    /**
     * @return string
     * @throws InvalidCommandDataException
     */
    public function getBody()
    {
        return $this->encode($this->data->jsonSerialize());
    }
    /**
     * @param UpdateOrderAdditionalFlags $additionalFlags
     * @return $this
     */
    public function setAdditionalFlags(UpdateOrderAdditionalFlags $additionalFlags)
    {
        $this->additionalFlags = $additionalFlags;
        return $this;
    }
    /**
     * @return int
     */
    public function getSuccessCode()
    {
        return 200;
    }
}
