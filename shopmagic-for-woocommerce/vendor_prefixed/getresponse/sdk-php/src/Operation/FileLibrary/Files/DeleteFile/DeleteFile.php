<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\FileLibrary\Files\DeleteFile;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class DeleteFile extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/file-library/files/{fileId}';
    /** @var string */
    private $fileId;
    /**
     * @param string $fileId
     */
    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{fileId}'], [$this->fileId], self::METHOD_URL);
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
