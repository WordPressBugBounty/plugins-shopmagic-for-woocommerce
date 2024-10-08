<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\PredefinedFields\UpdatePredefinedField;

use ShopMagicVendor\Getresponse\Sdk\Client\Exception\InvalidCommandDataException;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
use ShopMagicVendor\Getresponse\Sdk\Operation\Model\UpdatePredefinedField as ModelUpdatePredefinedField;
class UpdatePredefinedField extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/predefined-fields/{predefinedFieldId}';
    /** @var ModelUpdatePredefinedField */
    protected $data;
    /** @var string */
    private $predefinedFieldId;
    /**
     * @param ModelUpdatePredefinedField $data
     * @param string $predefinedFieldId
     */
    public function __construct(ModelUpdatePredefinedField $data, $predefinedFieldId)
    {
        $this->data = $data;
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
