<?php

declare (strict_types=1);
namespace ShopMagicVendor\Http\Client\Common;

use ShopMagicVendor\Http\Client\HttpAsyncClient;
use ShopMagicVendor\Http\Client\HttpClient;
use ShopMagicVendor\Http\Message\RequestMatcher;
use ShopMagicVendor\Psr\Http\Client\ClientInterface;
/**
 * Route a request to a specific client in the stack based using a RequestMatcher.
 *
 * This is not a HttpClientPool client because it uses a matcher to select the client.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
interface HttpClientRouterInterface extends HttpClient, HttpAsyncClient
{
    /**
     * Add a client to the router.
     *
     * @param ClientInterface|HttpAsyncClient $client
     */
    public function addClient($client, RequestMatcher $requestMatcher): void;
}
