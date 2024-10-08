<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\FileLibrary\Quota\GetQuota;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetQuota extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/file-library/quota';
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return self::METHOD_URL;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->buildUrlFromTemplate();
    }
}
