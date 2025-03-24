<?php

declare (strict_types=1);
namespace ShopMagicVendor\Http\Client\Common\Plugin;

use ShopMagicVendor\Http\Message\Stream\BufferedStream;
use ShopMagicVendor\Http\Promise\Promise;
use ShopMagicVendor\Psr\Http\Message\RequestInterface;
/**
 * Allow body used in request to be always seekable.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
final class RequestSeekableBodyPlugin extends SeekableBodyPlugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        if (!$request->getBody()->isSeekable()) {
            $request = $request->withBody(new BufferedStream($request->getBody(), $this->useFileBuffer, $this->memoryBufferSize));
        }
        return $next($request);
    }
}
