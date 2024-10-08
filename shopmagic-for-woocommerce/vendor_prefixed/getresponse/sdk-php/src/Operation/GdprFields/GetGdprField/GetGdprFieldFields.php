<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\GdprFields\GetGdprField;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetGdprFieldFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['gdprFieldId', 'name', 'createdOn', 'href', 'latestVersion'];
    }
}
