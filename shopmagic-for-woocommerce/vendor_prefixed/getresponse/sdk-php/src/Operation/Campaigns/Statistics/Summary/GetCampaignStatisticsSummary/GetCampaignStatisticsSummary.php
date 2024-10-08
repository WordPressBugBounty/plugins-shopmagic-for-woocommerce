<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Campaigns\Statistics\Summary\GetCampaignStatisticsSummary;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetCampaignStatisticsSummary extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/campaigns/statistics/summary';
    /** @var GetCampaignStatisticsSummarySearchQuery */
    private $query;
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return self::METHOD_URL;
    }
    /**
     * @param GetCampaignStatisticsSummarySearchQuery $query
     * @return $this
     */
    public function setQuery(GetCampaignStatisticsSummarySearchQuery $query)
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
