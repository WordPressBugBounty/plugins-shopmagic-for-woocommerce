<?php

namespace ShopMagicVendor\Http\Discovery\Strategy;

use ShopMagicVendor\Psr\Http\Message\RequestFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\ServerRequestFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\StreamFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\UploadedFileFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\UriFactoryInterface;
/**
 * @internal
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 *
 * Don't miss updating src/Composer/Plugin.php when adding a new supported class.
 */
final class CommonPsr17ClassesStrategy implements DiscoveryStrategy
{
    /**
     * @var array
     */
    private static $classes = [RequestFactoryInterface::class => ['ShopMagicVendor\Phalcon\Http\Message\RequestFactory', 'ShopMagicVendor\Nyholm\Psr7\Factory\Psr17Factory', 'ShopMagicVendor\GuzzleHttp\Psr7\HttpFactory', 'ShopMagicVendor\Http\Factory\Diactoros\RequestFactory', 'ShopMagicVendor\Http\Factory\Guzzle\RequestFactory', 'ShopMagicVendor\Http\Factory\Slim\RequestFactory', 'ShopMagicVendor\Laminas\Diactoros\RequestFactory', 'ShopMagicVendor\Slim\Psr7\Factory\RequestFactory', 'ShopMagicVendor\HttpSoft\Message\RequestFactory'], ResponseFactoryInterface::class => ['ShopMagicVendor\Phalcon\Http\Message\ResponseFactory', 'ShopMagicVendor\Nyholm\Psr7\Factory\Psr17Factory', 'ShopMagicVendor\GuzzleHttp\Psr7\HttpFactory', 'ShopMagicVendor\Http\Factory\Diactoros\ResponseFactory', 'ShopMagicVendor\Http\Factory\Guzzle\ResponseFactory', 'ShopMagicVendor\Http\Factory\Slim\ResponseFactory', 'ShopMagicVendor\Laminas\Diactoros\ResponseFactory', 'ShopMagicVendor\Slim\Psr7\Factory\ResponseFactory', 'ShopMagicVendor\HttpSoft\Message\ResponseFactory'], ServerRequestFactoryInterface::class => ['ShopMagicVendor\Phalcon\Http\Message\ServerRequestFactory', 'ShopMagicVendor\Nyholm\Psr7\Factory\Psr17Factory', 'ShopMagicVendor\GuzzleHttp\Psr7\HttpFactory', 'ShopMagicVendor\Http\Factory\Diactoros\ServerRequestFactory', 'ShopMagicVendor\Http\Factory\Guzzle\ServerRequestFactory', 'ShopMagicVendor\Http\Factory\Slim\ServerRequestFactory', 'ShopMagicVendor\Laminas\Diactoros\ServerRequestFactory', 'ShopMagicVendor\Slim\Psr7\Factory\ServerRequestFactory', 'ShopMagicVendor\HttpSoft\Message\ServerRequestFactory'], StreamFactoryInterface::class => ['ShopMagicVendor\Phalcon\Http\Message\StreamFactory', 'ShopMagicVendor\Nyholm\Psr7\Factory\Psr17Factory', 'ShopMagicVendor\GuzzleHttp\Psr7\HttpFactory', 'ShopMagicVendor\Http\Factory\Diactoros\StreamFactory', 'ShopMagicVendor\Http\Factory\Guzzle\StreamFactory', 'ShopMagicVendor\Http\Factory\Slim\StreamFactory', 'ShopMagicVendor\Laminas\Diactoros\StreamFactory', 'ShopMagicVendor\Slim\Psr7\Factory\StreamFactory', 'ShopMagicVendor\HttpSoft\Message\StreamFactory'], UploadedFileFactoryInterface::class => ['ShopMagicVendor\Phalcon\Http\Message\UploadedFileFactory', 'ShopMagicVendor\Nyholm\Psr7\Factory\Psr17Factory', 'ShopMagicVendor\GuzzleHttp\Psr7\HttpFactory', 'ShopMagicVendor\Http\Factory\Diactoros\UploadedFileFactory', 'ShopMagicVendor\Http\Factory\Guzzle\UploadedFileFactory', 'ShopMagicVendor\Http\Factory\Slim\UploadedFileFactory', 'ShopMagicVendor\Laminas\Diactoros\UploadedFileFactory', 'ShopMagicVendor\Slim\Psr7\Factory\UploadedFileFactory', 'ShopMagicVendor\HttpSoft\Message\UploadedFileFactory'], UriFactoryInterface::class => ['ShopMagicVendor\Phalcon\Http\Message\UriFactory', 'ShopMagicVendor\Nyholm\Psr7\Factory\Psr17Factory', 'ShopMagicVendor\GuzzleHttp\Psr7\HttpFactory', 'ShopMagicVendor\Http\Factory\Diactoros\UriFactory', 'ShopMagicVendor\Http\Factory\Guzzle\UriFactory', 'ShopMagicVendor\Http\Factory\Slim\UriFactory', 'ShopMagicVendor\Laminas\Diactoros\UriFactory', 'ShopMagicVendor\Slim\Psr7\Factory\UriFactory', 'ShopMagicVendor\HttpSoft\Message\UriFactory']];
    public static function getCandidates($type)
    {
        $candidates = [];
        if (isset(self::$classes[$type])) {
            foreach (self::$classes[$type] as $class) {
                $candidates[] = ['class' => $class, 'condition' => [$class]];
            }
        }
        return $candidates;
    }
}
