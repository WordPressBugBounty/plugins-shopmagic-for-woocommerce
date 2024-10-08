<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Addresses\GetAddress;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetAddress extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/addresses/{addressId}';
    /** @var string */
    private $addressId;
    /** @var GetAddressFields */
    private $fields;
    /**
     * @param string $addressId
     */
    public function __construct($addressId)
    {
        $this->addressId = $addressId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{addressId}'], [$this->addressId], self::METHOD_URL);
    }
    /**
     * @param GetAddressFields $fields
     * @return $this
     */
    public function setFields(GetAddressFields $fields)
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
