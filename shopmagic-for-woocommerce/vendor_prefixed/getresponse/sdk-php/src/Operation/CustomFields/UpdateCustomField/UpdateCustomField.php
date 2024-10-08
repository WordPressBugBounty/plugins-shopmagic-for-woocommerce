<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\CustomFields\UpdateCustomField;

use ShopMagicVendor\Getresponse\Sdk\Client\Exception\InvalidCommandDataException;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
use ShopMagicVendor\Getresponse\Sdk\Operation\Model\UpdateCustomField as ModelUpdateCustomField;
class UpdateCustomField extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/custom-fields/{customFieldId}';
    /** @var ModelUpdateCustomField */
    protected $data;
    /** @var string */
    private $customFieldId;
    /**
     * @param ModelUpdateCustomField $data
     * @param string $customFieldId
     */
    public function __construct(ModelUpdateCustomField $data, $customFieldId)
    {
        $this->data = $data;
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
     * @return int
     */
    public function getSuccessCode()
    {
        return 200;
    }
}
