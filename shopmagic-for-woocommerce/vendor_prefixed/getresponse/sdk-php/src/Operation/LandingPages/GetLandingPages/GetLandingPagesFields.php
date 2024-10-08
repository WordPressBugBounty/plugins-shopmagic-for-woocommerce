<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\LandingPages\GetLandingPages;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetLandingPagesFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['landingPageId', 'href', 'metaTitle', 'domain', 'subdomain', 'userDomain', 'userDomainPath', 'campaign', 'status', 'userDomainStatus', 'testAB', 'createdOn', 'updatedOn'];
    }
}
