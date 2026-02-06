<?php

namespace ShopMagicVendor\MailerLite\Http;

use ShopMagicVendor\Psr\Http\Message\RequestInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseInterface;
interface ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface;
}
