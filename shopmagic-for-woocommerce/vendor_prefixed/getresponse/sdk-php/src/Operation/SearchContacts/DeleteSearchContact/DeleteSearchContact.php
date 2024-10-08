<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\SearchContacts\DeleteSearchContact;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class DeleteSearchContact extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/search-contacts/{searchContactId}';
    /** @var string */
    private $searchContactId;
    /**
     * @param string $searchContactId
     */
    public function __construct($searchContactId)
    {
        $this->searchContactId = $searchContactId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{searchContactId}'], [$this->searchContactId], self::METHOD_URL);
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
        return Operation::DELETE;
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
        return 204;
    }
}
