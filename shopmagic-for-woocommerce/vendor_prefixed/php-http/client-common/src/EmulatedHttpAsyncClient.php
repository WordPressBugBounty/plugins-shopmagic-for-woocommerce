<?php

declare (strict_types=1);
namespace ShopMagicVendor\Http\Client\Common;

use ShopMagicVendor\Http\Client\HttpAsyncClient;
use ShopMagicVendor\Http\Client\HttpClient;
use ShopMagicVendor\Psr\Http\Client\ClientInterface;
/**
 * Emulates an async HTTP client with the help of a synchronous client.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class EmulatedHttpAsyncClient implements HttpClient, HttpAsyncClient
{
    use HttpAsyncClientEmulator;
    use HttpClientDecorator;
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
