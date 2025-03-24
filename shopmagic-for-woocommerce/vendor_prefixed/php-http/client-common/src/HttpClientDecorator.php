<?php

declare (strict_types=1);
namespace ShopMagicVendor\Http\Client\Common;

use ShopMagicVendor\Psr\Http\Client\ClientInterface;
use ShopMagicVendor\Psr\Http\Message\RequestInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseInterface;
/**
 * Decorates an HTTP Client.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait HttpClientDecorator
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;
    /**
     * @see ClientInterface::sendRequest
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->httpClient->sendRequest($request);
    }
}
