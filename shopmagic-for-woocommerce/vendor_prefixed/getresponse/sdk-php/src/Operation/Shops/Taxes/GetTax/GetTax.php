<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Shops\Taxes\GetTax;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetTax extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/shops/{shopId}/taxes/{taxId}';
    /** @var string */
    private $shopId;
    /** @var string */
    private $taxId;
    /** @var GetTaxFields */
    private $fields;
    /**
     * @param string $shopId
     * @param string $taxId
     */
    public function __construct($shopId, $taxId)
    {
        $this->shopId = $shopId;
        $this->taxId = $taxId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{shopId}', '{taxId}'], [$this->shopId, $this->taxId], self::METHOD_URL);
    }
    /**
     * @param GetTaxFields $fields
     * @return $this
     */
    public function setFields(GetTaxFields $fields)
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
