<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Suppressions\UpdateSuppression;

use ShopMagicVendor\Getresponse\Sdk\Client\Exception\InvalidCommandDataException;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
use ShopMagicVendor\Getresponse\Sdk\Operation\Model\UpdateSuppression as ModelUpdateSuppression;
class UpdateSuppression extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/suppressions/{suppressionId}';
    /** @var ModelUpdateSuppression */
    protected $data;
    /** @var string */
    private $suppressionId;
    /**
     * @param ModelUpdateSuppression $data
     * @param string $suppressionId
     */
    public function __construct(ModelUpdateSuppression $data, $suppressionId)
    {
        $this->data = $data;
        $this->suppressionId = $suppressionId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{suppressionId}'], [$this->suppressionId], self::METHOD_URL);
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
