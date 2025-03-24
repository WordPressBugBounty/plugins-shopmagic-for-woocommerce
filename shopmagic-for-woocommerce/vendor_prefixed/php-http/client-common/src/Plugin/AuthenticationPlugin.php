<?php

declare (strict_types=1);
namespace ShopMagicVendor\Http\Client\Common\Plugin;

use ShopMagicVendor\Http\Client\Common\Plugin;
use ShopMagicVendor\Http\Message\Authentication;
use ShopMagicVendor\Http\Promise\Promise;
use ShopMagicVendor\Psr\Http\Message\RequestInterface;
/**
 * Send an authenticated request.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
final class AuthenticationPlugin implements Plugin
{
    /**
     * @var Authentication An authentication system
     */
    private $authentication;
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $request = $this->authentication->authenticate($request);
        return $next($request);
    }
}
