<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Contacts\Activities\GetActivities;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\DateRangeSearch;
use ShopMagicVendor\Getresponse\Sdk\Client\Operation\SearchQuery;
class GetActivitiesSearchQuery extends SearchQuery
{
    /**
     * @return array
     */
    public function getAllowedKeys()
    {
        return ['createdOn'];
    }
    /**
     * @param DateRangeSearch $createdOn
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function whereCreatedOn(DateRangeSearch $createdOn)
    {
        return $this->set('createdOn', $createdOn->toArray());
    }
}
