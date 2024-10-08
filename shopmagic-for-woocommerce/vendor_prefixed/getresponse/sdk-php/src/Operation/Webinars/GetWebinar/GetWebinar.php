<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Webinars\GetWebinar;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetWebinar extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/webinars/{webinarId}';
    /** @var string */
    private $webinarId;
    /** @var GetWebinarFields */
    private $fields;
    /**
     * @param string $webinarId
     */
    public function __construct($webinarId)
    {
        $this->webinarId = $webinarId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{webinarId}'], [$this->webinarId], self::METHOD_URL);
    }
    /**
     * @param GetWebinarFields $fields
     * @return $this
     */
    public function setFields(GetWebinarFields $fields)
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
