<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Forms\Variants\GetVariants;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetVariantsFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['formId', 'webformId', 'variant', 'variantName', 'winner', 'status', 'createdOn', 'numberOfVisitors', 'numberOfUniqueVisitors', 'numberOfSubscribers', 'subscriptionRate'];
    }
}
