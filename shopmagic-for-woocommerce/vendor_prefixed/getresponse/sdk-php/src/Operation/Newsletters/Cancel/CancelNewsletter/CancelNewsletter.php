<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Newsletters\Cancel\CancelNewsletter;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class CancelNewsletter extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/newsletters/{newsletterId}/cancel';
    /** @var string */
    private $newsletterId;
    /**
     * @param string $newsletterId
     */
    public function __construct($newsletterId)
    {
        $this->newsletterId = $newsletterId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{newsletterId}'], [$this->newsletterId], self::METHOD_URL);
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->buildUrlFromTemplate();
    }
    /**
     * @return string
     */
    public function getMethod()
    {
        return Operation::POST;
    }
    /**
     * @return string
     */
    public function getBody()
    {
        return '';
    }
    /**
     * @return int
     */
    public function getSuccessCode()
    {
        return 200;
    }
}
