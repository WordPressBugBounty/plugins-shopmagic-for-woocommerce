<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Campaigns\Statistics\Subscriptions\GetCampaignStatisticsSubscriptions;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetCampaignStatisticsSubscriptions extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/campaigns/statistics/subscriptions';
    /** @var GetCampaignStatisticsSubscriptionsSearchQuery */
    private $query;
    /**
     * @param GetCampaignStatisticsSubscriptionsSearchQuery $query
     */
    public function __construct(GetCampaignStatisticsSubscriptionsSearchQuery $query)
    {
        $this->query = $query;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return self::METHOD_URL;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->buildUrlFromTemplate() . $this->buildQueryString($this->query, null, null);
    }
}
