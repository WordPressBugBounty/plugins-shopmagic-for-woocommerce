<?php

namespace ShopMagicVendor\Getresponse\Sdk\Environment;

use ShopMagicVendor\Getresponse\Sdk\Client\Environment\Environment;
use ShopMagicVendor\Psr\Http\Message\RequestInterface;
/**
 * Class GetResponse
 * @package Getresponse\Sdk\Environment
 */
class GetResponse implements Environment
{
    public const URL = 'https://api.getresponse.com';
    /**
     * @return string
     */
    public function getUrl()
    {
        return self::URL;
    }
    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function processRequest(RequestInterface $request)
    {
        // no processing required
        return $request;
    }
}
