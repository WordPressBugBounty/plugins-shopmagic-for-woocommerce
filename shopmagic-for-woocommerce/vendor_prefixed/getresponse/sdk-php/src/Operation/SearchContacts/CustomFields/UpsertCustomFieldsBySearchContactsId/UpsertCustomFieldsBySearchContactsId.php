<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\SearchContacts\CustomFields\UpsertCustomFieldsBySearchContactsId;

use ShopMagicVendor\Getresponse\Sdk\Client\Exception\InvalidCommandDataException;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\CommandOperation;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Operation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
use ShopMagicVendor\Getresponse\Sdk\Operation\Model\UpsertContactCustomFields;
class UpsertCustomFieldsBySearchContactsId extends CommandOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/search-contacts/{searchContactId}/custom-fields';
    /** @var UpsertContactCustomFields */
    protected $data;
    /** @var string */
    private $searchContactId;
    /**
     * @param UpsertContactCustomFields $data
     * @param string $searchContactId
     */
    public function __construct(UpsertContactCustomFields $data, $searchContactId)
    {
        $this->data = $data;
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
        return Operation::POST;
    }
    /**
     * @return string
     * @throws InvalidCommandDataException
     */
    public function getBody()
    {
        return $this->encode($this->data->jsonSerialize());
    }
    /**
     * @return int
     */
    public function getSuccessCode()
    {
        return 202;
    }
}
