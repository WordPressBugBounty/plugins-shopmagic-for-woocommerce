<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Autoresponders\GetAutoresponders;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Pagination;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetAutoresponders extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/autoresponders';
    /** @var GetAutorespondersSearchQuery */
    private $query;
    /** @var GetAutorespondersSortParams */
    private $sort;
    /** @var Pagination */
    private $pagination;
    /** @var GetAutorespondersFields */
    private $fields;
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return self::METHOD_URL;
    }
    /**
     * @param GetAutorespondersSearchQuery $query
     * @return $this
     */
    public function setQuery(GetAutorespondersSearchQuery $query)
    {
        $this->query = $query;
        return $this;
    }
    /**
     * @param GetAutorespondersSortParams $sort
     * @return $this
     */
    public function setSort(GetAutorespondersSortParams $sort)
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
     * @param GetAutorespondersFields $fields
     * @return $this
     */
    public function setFields(GetAutorespondersFields $fields)
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