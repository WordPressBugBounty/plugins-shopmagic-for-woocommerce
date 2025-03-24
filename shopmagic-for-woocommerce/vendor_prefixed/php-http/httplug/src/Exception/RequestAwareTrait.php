<?php

namespace ShopMagicVendor\Http\Client\Exception;

use ShopMagicVendor\Psr\Http\Message\RequestInterface;
trait RequestAwareTrait
{
    /**
     * @var RequestInterface
     */
    private $request;
    private function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
