<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Autoresponders\Statistics\GetAutoresponderStatistics;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetAutoresponderStatisticsFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['timeInterval', 'sent', 'totalOpened', 'uniqueOpened', 'totalClicked', 'uniqueClicked', 'goals', 'uniqueGoals', 'forwarded', 'unsubscribed', 'bounced', 'complaints'];
    }
}
