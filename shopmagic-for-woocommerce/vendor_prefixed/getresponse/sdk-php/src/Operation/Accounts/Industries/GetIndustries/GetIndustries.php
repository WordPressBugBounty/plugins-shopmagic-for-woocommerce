<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Accounts\Industries\GetIndustries;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Pagination;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetIndustries extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/accounts/industries';
    /** @var Pagination */
    private $pagination;
    /** @var GetIndustriesFields */
    private $fields;
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return self::METHOD_URL;
    }
    /**
     * @param Pagination $pagination
     * @return $this
     */
    public function setPagination(Pagination $pagination)
    {
        $this->pagination = $pagination;
        return $this;
    }
    /**
     * @param GetIndustriesFields $fields
     * @return $this
     */
    public function setFields(GetIndustriesFields $fields)
    {
        $this->fields = $fields;
        return $this;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        $extra = array_merge($this->getPaginationParametersArray($this->pagination), $this->getFieldsParameterArray($this->fields));
        return $this->buildUrlFromTemplate() . $this->buildQueryString(null, null, $extra);
    }
}
