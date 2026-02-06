<?php

namespace ShopMagicVendor\MailerLite\Http;

use ShopMagicVendor\Psr\Http\Message\RequestInterface;
interface RequestFactoryInterface
{
    /**
     * @param array<string, string|string[]> $headers
     */
    public function create(string $method, string $uri, array $headers = [], ?string $body = null): RequestInterface;
}
