<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Accounts\LoginHistory\GetLoginHistory;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Pagination;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetLoginHistory extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/accounts/login-history';
    /** @var Pagination */
    private $pagination;
    /** @var GetLoginHistoryFields */
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
     * @param GetLoginHistoryFields $fields
     * @return $this
     */
    public function setFields(GetLoginHistoryFields $fields)
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
