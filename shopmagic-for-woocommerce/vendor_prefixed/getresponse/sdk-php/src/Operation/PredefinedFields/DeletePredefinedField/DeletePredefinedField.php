<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\PredefinedFields\DeletePredefinedField;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class DeletePredefinedField extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/predefined-fields/{predefinedFieldId}';
    /** @var string */
    private $predefinedFieldId;
    /**
     * @param string $predefinedFieldId
     */
    public function __construct($predefinedFieldId)
    {
        $this->predefinedFieldId = $predefinedFieldId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{predefinedFieldId}'], [$this->predefinedFieldId], self::METHOD_URL);
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
