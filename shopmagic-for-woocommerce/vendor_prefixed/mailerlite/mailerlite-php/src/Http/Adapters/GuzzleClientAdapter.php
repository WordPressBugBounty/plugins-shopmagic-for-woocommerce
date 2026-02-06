<?php

namespace ShopMagicVendor\MailerLite\Http\Adapters;

use ShopMagicVendor\MailerLite\Http\ClientInterface;
use ShopMagicVendor\Psr\Http\Client\ClientInterface as Psr18Client;
use ShopMagicVendor\Psr\Http\Message\RequestInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseInterface;
final class GuzzleClientAdapter implements ClientInterface
{
    /** @var Psr18Client */
    private $client;
    public function __construct(Psr18Client $client)
    {
        $this->client = $client;
    }
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }
}
