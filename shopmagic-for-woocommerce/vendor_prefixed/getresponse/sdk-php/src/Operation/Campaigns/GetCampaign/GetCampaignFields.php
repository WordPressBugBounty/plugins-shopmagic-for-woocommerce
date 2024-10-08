<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Campaigns\GetCampaign;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetCampaignFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['campaignId', 'name', 'languageCode', 'isDefault', 'createdOn', 'href', 'postal', 'confirmation', 'optinTypes', 'subscriptionNotifications', 'profile'];
    }
}
