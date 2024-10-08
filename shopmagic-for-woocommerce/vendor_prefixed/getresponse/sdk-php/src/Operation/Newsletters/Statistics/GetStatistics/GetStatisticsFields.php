<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Newsletters\Statistics\GetStatistics;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetStatisticsFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['timeInterval', 'sent', 'totalOpened', 'uniqueOpened', 'totalClicked', 'uniqueClicked', 'goals', 'uniqueGoals', 'forwarded', 'unsubscribed', 'bounced', 'complaints'];
    }
}
