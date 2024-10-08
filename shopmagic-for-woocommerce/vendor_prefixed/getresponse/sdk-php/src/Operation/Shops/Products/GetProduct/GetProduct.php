<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Shops\Products\GetProduct;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetProduct extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/shops/{shopId}/products/{productId}';
    /** @var string */
    private $shopId;
    /** @var string */
    private $productId;
    /** @var GetProductFields */
    private $fields;
    /**
     * @param string $shopId
     * @param string $productId
     */
    public function __construct($shopId, $productId)
    {
        $this->shopId = $shopId;
        $this->productId = $productId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{shopId}', '{productId}'], [$this->shopId, $this->productId], self::METHOD_URL);
    }
    /**
     * @param GetProductFields $fields
     * @return $this
     */
    public function setFields(GetProductFields $fields)
    {
        $this->fields = $fields;
        return $this;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        $extra = $this->getFieldsParameterArray($this->fields);
        return $this->buildUrlFromTemplate() . $this->buildQueryString(null, null, $extra);
    }
}
