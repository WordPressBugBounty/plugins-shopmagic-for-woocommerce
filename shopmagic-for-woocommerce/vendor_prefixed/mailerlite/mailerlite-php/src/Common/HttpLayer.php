<?php

namespace ShopMagicVendor\MailerLite\Common;

use ShopMagicVendor\Http\Client\Common\Plugin\AuthenticationPlugin;
use ShopMagicVendor\Http\Client\Common\Plugin\ContentTypePlugin;
use ShopMagicVendor\Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use ShopMagicVendor\Http\Client\Common\PluginClient;
use ShopMagicVendor\Http\Client\HttpClient;
use ShopMagicVendor\Http\Discovery\Psr17FactoryDiscovery;
use ShopMagicVendor\Http\Discovery\Psr18ClientDiscovery;
use ShopMagicVendor\Http\Message\Authentication\Bearer;
use ShopMagicVendor\MailerLite\Helpers\HttpErrorHelper;
use ShopMagicVendor\Psr\Http\Client\ClientInterface;
use ShopMagicVendor\Psr\Http\Message\RequestFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\ResponseInterface;
use ShopMagicVendor\Psr\Http\Message\StreamFactoryInterface;
use ShopMagicVendor\Psr\Http\Message\StreamInterface;
class HttpLayer
{
    protected HttpClient $pluginClient;
    protected RequestFactoryInterface $requestFactory;
    protected StreamFactoryInterface $streamFactory;
    /**
     * @var array<string, mixed>
     */
    protected array $options;
    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options = [], ?ClientInterface $httpClient = null, ?RequestFactoryInterface $requestFactory = null, ?StreamFactoryInterface $streamFactory = null)
    {
        $this->options = $options;
        $httpClient = $httpClient ?: Psr18ClientDiscovery::find();
        $this->pluginClient = new PluginClient($httpClient, $this->buildPlugins());
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();
    }
    /**
     * @param array<string, mixed> $body
     * @param array<string, string> $headers
     *
     * @return array<string, mixed>
     */
    public function get(string $uri, array $body = [], array $headers = []): array
    {
        return $this->callMethod('GET', $uri, $body, $headers);
    }
    /**
     * @param array<mixed>|null $body null sends the request with no body
     * @param array<string, string> $headers
     *
     * @return array<string, mixed>
     */
    public function post(string $uri, ?array $body = [], array $headers = []): array
    {
        return $this->callMethod('POST', $uri, $body, $headers);
    }
    /**
     * @param array<string, mixed> $body
     * @param array<string, string> $headers
     *
     * @return array<string, mixed>
     */
    public function put(string $uri, array $body, array $headers = []): array
    {
        return $this->callMethod('PUT', $uri, $body, $headers);
    }
    /**
     * @param array<string, mixed> $body
     * @param array<string, string> $headers
     *
     * @return array<string, mixed>
     */
    public function patch(string $uri, array $body = [], array $headers = []): array
    {
        return $this->callMethod('PATCH', $uri, $body, $headers);
    }
    /**
     * @param array<string, mixed> $body
     * @param array<string, string> $headers
     *
     * @return array<string, mixed>
     */
    public function delete(string $uri, array $body = [], array $headers = []): array
    {
        return $this->callMethod('DELETE', $uri, $body, $headers);
    }
    /**
     * @param array<mixed>|null $body null sends the request with no body
     * @param array<string, string> $headers
     *
     * @return array<string, mixed>
     */
    protected function callMethod(string $method, string $uri, ?array $body, array $headers = []): array
    {
        $request = $this->requestFactory->createRequest($method, $uri);
        if ($body !== null) {
            $request = $request->withBody($this->buildBody($body));
        }
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }
        return $this->buildResponse($this->pluginClient->sendRequest($request));
    }
    /**
     * @return array<string, mixed>
     */
    public function request(string $method, string $uri, string $body = ''): array
    {
        $request = $this->requestFactory->createRequest($method, $uri);
        if (!empty($body)) {
            $request = $request->withBody($this->streamFactory->createStream($body));
        }
        return $this->buildResponse($this->pluginClient->sendRequest($request));
    }
    /**
     * @param array<string, mixed>|string $body
     */
    protected function buildBody($body): StreamInterface
    {
        $stringBody = is_array($body) ? json_encode($body, \JSON_THROW_ON_ERROR) : $body;
        return $this->streamFactory->createStream($stringBody);
    }
    /**
     * @return array<string, mixed>
     */
    protected function buildResponse(ResponseInterface $response): array
    {
        $contentTypes = $response->getHeader('Content-Type');
        $contentType = $response->hasHeader('Content-Type') ? reset($contentTypes) : null;
        switch ($contentType) {
            case 'application/json':
                $body = json_decode($response->getBody()->getContents(), \true, 512, \JSON_THROW_ON_ERROR);
                break;
            default:
                $body = $response->getBody()->getContents();
        }
        return ['status_code' => $response->getStatusCode(), 'headers' => $response->getHeaders(), 'body' => $body, 'response' => $response, 'is_idempotent_replay' => $this->isIdempotentReplay($response)];
    }
    protected function isIdempotentReplay(ResponseInterface $response): bool
    {
        return strcasecmp($response->getHeaderLine('Idempotent-Replayed'), 'true') === 0;
    }
    /**
     * @return array<int, \Http\Client\Common\Plugin>
     */
    protected function buildPlugins(): array
    {
        /** @var string $apiKey */
        $apiKey = $this->options['api_key'];
        $authentication = new Bearer($apiKey);
        $authenticationPlugin = new AuthenticationPlugin($authentication);
        $contentTypePlugin = new ContentTypePlugin();
        $headerDefaultsPlugin = new HeaderDefaultsPlugin(['User-Agent' => 'mailerlite-php/' . Constants::SDK_VERSION]);
        $httpErrorPlugin = new HttpErrorHelper();
        return [$authenticationPlugin, $contentTypePlugin, $headerDefaultsPlugin, $httpErrorPlugin];
    }
}
