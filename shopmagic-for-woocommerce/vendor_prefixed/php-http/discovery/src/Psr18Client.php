<?php

namespace ShopMagicVendor\Http\Discovery;

use ShopMagicVendor\Psr\Http\Client\ClientInterface;
use ShopMagicVendor\Psr\Http\Message\RequestFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\RequestInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseInterface;
use ShopMagicVendor\Psr\Http\Message\ServerRequestFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\StreamFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\UploadedFileFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\UriFactoryInterface;
/**
 * A generic PSR-18 and PSR-17 implementation.
 *
 * You can create this class with concrete client and factory instances
 * or let it use discovery to find suitable implementations as needed.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Psr18Client extends Psr17Factory implements ClientInterface
{
    private $client;
    public function __construct(?ClientInterface $client = null, ?RequestFactoryInterface $requestFactory = null, ?ResponseFactoryInterface $responseFactory = null, ?ServerRequestFactoryInterface $serverRequestFactory = null, ?StreamFactoryInterface $streamFactory = null, ?UploadedFileFactoryInterface $uploadedFileFactory = null, ?UriFactoryInterface $uriFactory = null)
    {
        $requestFactory ?? $requestFactory = $client instanceof RequestFactoryInterface ? $client : null;
        $responseFactory ?? $responseFactory = $client instanceof ResponseFactoryInterface ? $client : null;
        $serverRequestFactory ?? $serverRequestFactory = $client instanceof ServerRequestFactoryInterface ? $client : null;
        $streamFactory ?? $streamFactory = $client instanceof StreamFactoryInterface ? $client : null;
        $uploadedFileFactory ?? $uploadedFileFactory = $client instanceof UploadedFileFactoryInterface ? $client : null;
        $uriFactory ?? $uriFactory = $client instanceof UriFactoryInterface ? $client : null;
        parent::__construct($requestFactory, $responseFactory, $serverRequestFactory, $streamFactory, $uploadedFileFactory, $uriFactory);
        $this->client = $client ?? Psr18ClientDiscovery::find();
    }
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }
}
