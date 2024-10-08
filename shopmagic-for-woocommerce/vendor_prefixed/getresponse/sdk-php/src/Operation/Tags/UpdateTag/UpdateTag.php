<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Tags\UpdateTag;

use ShopMagicVendor\Getresponse\Sdk\Client\Exception\InvalidCommandDataException;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
use ShopMagicVendor\Getresponse\Sdk\Operation\Model\UpdateTag as ModelUpdateTag;
class UpdateTag extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/tags/{tagId}';
    /** @var ModelUpdateTag */
    protected $data;
    /** @var string */
    private $tagId;
    /**
     * @param ModelUpdateTag $data
     * @param string $tagId
     */
    public function __construct(ModelUpdateTag $data, $tagId)
    {
        $this->data = $data;
        $this->tagId = $tagId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{tagId}'], [$this->tagId], self::METHOD_URL);
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
