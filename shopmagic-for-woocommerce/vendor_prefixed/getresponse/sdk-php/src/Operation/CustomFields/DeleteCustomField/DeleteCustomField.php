<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\CustomFields\DeleteCustomField;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class DeleteCustomField extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/custom-fields/{customFieldId}';
    /** @var string */
    private $customFieldId;
    /**
     * @param string $customFieldId
     */
    public function __construct($customFieldId)
    {
        $this->customFieldId = $customFieldId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{customFieldId}'], [$this->customFieldId], self::METHOD_URL);
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
