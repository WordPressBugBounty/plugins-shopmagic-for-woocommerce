<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\SubscriptionConfirmations\Body\GetBody;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetBody extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/subscription-confirmations/body/{languageCode}';
    /** @var string */
    private $languageCode;
    /** @var GetBodyFields */
    private $fields;
    /**
     * @param string $languageCode
     */
    public function __construct($languageCode)
    {
        $this->languageCode = $languageCode;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{languageCode}'], [$this->languageCode], self::METHOD_URL);
    }
    /**
     * @param GetBodyFields $fields
     * @return $this
     */
    public function setFields(GetBodyFields $fields)
    {
        $this->fields = $fields;
        return $this;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        $extra = array_merge($this->getFieldsParameterArray($this->fields));
        return $this->buildUrlFromTemplate() . $this->buildQueryString(null, null, $extra);
    }
}
