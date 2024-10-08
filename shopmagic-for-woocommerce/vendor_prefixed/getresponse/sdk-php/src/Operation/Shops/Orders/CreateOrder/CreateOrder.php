<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Shops\Orders\CreateOrder;

use ShopMagicVendor\Getresponse\Sdk\Client\Exception\InvalidCommandDataException;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
use ShopMagicVendor\Getresponse\Sdk\Operation\Model\NewOrder;
class CreateOrder extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/shops/{shopId}/orders';
    /** @var NewOrder */
    protected $data;
    /** @var string */
    private $shopId;
    /** @var CreateOrderAdditionalFlags */
    private $additionalFlags;
    /**
     * @param NewOrder $data
     * @param string $shopId
     */
    public function __construct(NewOrder $data, $shopId)
    {
        $this->data = $data;
        $this->shopId = $shopId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{shopId}'], [$this->shopId], self::METHOD_URL);
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
     * @param CreateOrderAdditionalFlags $additionalFlags
     * @return $this
     */
    public function setAdditionalFlags(CreateOrderAdditionalFlags $additionalFlags)
    {
        $this->additionalFlags = $additionalFlags;
        return $this;
    }
    /**
     * @return int
     */
    public function getSuccessCode()
    {
        return 201;
    }
}
