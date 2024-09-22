<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Newsletters\GetNewsletters;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\SortParams;
class GetNewslettersSortParams extends SortParams
{
    /**
     * @return array
     */
    public function getAllowedKeys()
    {
        return ['createdOn'];
    }
}
