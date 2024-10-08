<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\RssNewsletters\Statistics\GetRssNewsletterStatistics;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetRssNewsletterStatisticsFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['timeInterval', 'sent', 'totalOpened', 'uniqueOpened', 'totalClicked', 'uniqueClicked', 'goals', 'uniqueGoals', 'forwarded', 'unsubscribed', 'bounced', 'complaints'];
    }
}
