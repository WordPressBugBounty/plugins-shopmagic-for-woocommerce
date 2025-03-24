<?php

namespace ShopMagicVendor\MailerLite\Helpers;

use ShopMagicVendor\Http\Client\Common\Plugin;
use ShopMagicVendor\Http\Promise\Promise;
use ShopMagicVendor\MailerLite\Exceptions\MailerLiteValidationException;
use ShopMagicVendor\MailerLite\Exceptions\MailerLiteHttpException;
use ShopMagicVendor\Psr\Http\Message\RequestInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseInterface;
class HttpErrorHelper implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $promise = $next($request);
        return $promise->then(function (ResponseInterface $response) use ($request) {
            $code = $response->getStatusCode();
            if ($code >= 200 && $code < 400) {
                return $response;
            }
            if ($code === 422) {
                throw new MailerLiteValidationException($request, $response);
            }
            throw new MailerLiteHttpException($request, $response);
        });
    }
}
