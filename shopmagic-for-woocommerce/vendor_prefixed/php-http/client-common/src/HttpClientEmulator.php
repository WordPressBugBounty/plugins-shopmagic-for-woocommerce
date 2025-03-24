<?php

declare (strict_types=1);
namespace ShopMagicVendor\Http\Client\Common;

use ShopMagicVendor\Psr\Http\Message\RequestInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseInterface;
/**
 * Emulates an HTTP Client in an HTTP Async Client.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait HttpClientEmulator
{
    /**
     * @see HttpClient::sendRequest
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $promise = $this->sendAsyncRequest($request);
        return $promise->wait();
    }
    /**
     * @see HttpAsyncClient::sendAsyncRequest
     */
    abstract public function sendAsyncRequest(RequestInterface $request);
}
