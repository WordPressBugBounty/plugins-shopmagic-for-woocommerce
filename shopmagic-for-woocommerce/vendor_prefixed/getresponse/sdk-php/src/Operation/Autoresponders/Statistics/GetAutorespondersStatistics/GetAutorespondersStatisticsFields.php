<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Autoresponders\Statistics\GetAutorespondersStatistics;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetAutorespondersStatisticsFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['timeInterval', 'sent', 'totalOpened', 'uniqueOpened', 'totalClicked', 'uniqueClicked', 'goals', 'uniqueGoals', 'forwarded', 'unsubscribed', 'bounced', 'complaints'];
    }
}
