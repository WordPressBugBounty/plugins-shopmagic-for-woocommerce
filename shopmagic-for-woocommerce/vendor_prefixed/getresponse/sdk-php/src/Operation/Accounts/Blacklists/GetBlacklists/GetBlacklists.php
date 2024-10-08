<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Accounts\Blacklists\GetBlacklists;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetBlacklists extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/accounts/blacklists';
    /** @var GetBlacklistsSearchQuery */
    private $query;
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return self::METHOD_URL;
    }
    /**
     * @param GetBlacklistsSearchQuery $query
     * @return $this
     */
    public function setQuery(GetBlacklistsSearchQuery $query)
    {
        $this->query = $query;
        return $this;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->buildUrlFromTemplate() . $this->buildQueryString($this->query, null, null);
    }
}
