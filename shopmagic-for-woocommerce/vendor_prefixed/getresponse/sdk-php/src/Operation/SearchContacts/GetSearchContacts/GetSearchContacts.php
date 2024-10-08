<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\SearchContacts\GetSearchContacts;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Pagination;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetSearchContacts extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/search-contacts';
    /** @var GetSearchContactsSearchQuery */
    private $query;
    /** @var GetSearchContactsSortParams */
    private $sort;
    /** @var Pagination */
    private $pagination;
    /** @var GetSearchContactsFields */
    private $fields;
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return self::METHOD_URL;
    }
    /**
     * @param GetSearchContactsSearchQuery $query
     * @return $this
     */
    public function setQuery(GetSearchContactsSearchQuery $query)
    {
        $this->query = $query;
        return $this;
    }
    /**
     * @param GetSearchContactsSortParams $sort
     * @return $this
     */
    public function setSort(GetSearchContactsSortParams $sort)
    {
        $this->sort = $sort;
        return $this;
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
     * @param GetSearchContactsFields $fields
     * @return $this
     */
    public function setFields(GetSearchContactsFields $fields)
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
        return $this->buildUrlFromTemplate() . $this->buildQueryString($this->query, $this->sort, $extra);
    }
}
