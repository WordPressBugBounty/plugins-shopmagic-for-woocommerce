<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\GdprFields\GetGdprField;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetGdprField extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/gdpr-fields/{gdprFieldId}';
    /** @var string */
    private $gdprFieldId;
    /** @var GetGdprFieldFields */
    private $fields;
    /**
     * @param string $gdprFieldId
     */
    public function __construct($gdprFieldId)
    {
        $this->gdprFieldId = $gdprFieldId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{gdprFieldId}'], [$this->gdprFieldId], self::METHOD_URL);
    }
    /**
     * @param GetGdprFieldFields $fields
     * @return $this
     */
    public function setFields(GetGdprFieldFields $fields)
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
