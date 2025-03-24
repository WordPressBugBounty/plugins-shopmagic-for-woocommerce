<?php

declare (strict_types=1);
namespace ShopMagicVendor\Http\Client\Common;

use ShopMagicVendor\Http\Client\Common\HttpClientPool\HttpClientPoolItem;
use ShopMagicVendor\Http\Client\HttpAsyncClient;
use ShopMagicVendor\Http\Client\HttpClient;
use ShopMagicVendor\Psr\Http\Client\ClientInterface;
/**
 * A http client pool allows to send requests on a pool of different http client using a specific strategy (least used,
 * round robin, ...).
 */
interface HttpClientPool extends HttpAsyncClient, HttpClient
{
    /**
     * Add a client to the pool.
     *
     * @param ClientInterface|HttpAsyncClient|HttpClientPoolItem $client
     */
    public function addHttpClient($client): void;
}
