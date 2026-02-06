<?php

namespace ShopMagicVendor\MailerLite\Http;

use ShopMagicVendor\Psr\Http\Message\StreamInterface;
interface StreamFactoryInterface
{
    public function createStream(string $content): StreamInterface;
}
