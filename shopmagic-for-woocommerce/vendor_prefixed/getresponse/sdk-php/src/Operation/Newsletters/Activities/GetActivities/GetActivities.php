<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Newsletters\Activities\GetActivities;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\Pagination;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetActivities extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/newsletters/{newsletterId}/activities';
    /** @var string */
    private $newsletterId;
    /** @var GetActivitiesSearchQuery */
    private $query;
    /** @var GetActivitiesSortParams */
    private $sort;
    /** @var Pagination */
    private $pagination;
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
     * @param GetActivitiesSearchQuery $query
     * @return $this
     */
    public function setQuery(GetActivitiesSearchQuery $query)
    {
        $this->query = $query;
        return $this;
    }
    /**
     * @param GetActivitiesSortParams $sort
     * @return $this
     */
    public function setSort(GetActivitiesSortParams $sort)
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
     * @return string
     */
    public function getUrl()
    {
        $extra = array_merge($this->getPaginationParametersArray($this->pagination));
        return $this->buildUrlFromTemplate() . $this->buildQueryString($this->query, $this->sort, $extra);
    }
}
