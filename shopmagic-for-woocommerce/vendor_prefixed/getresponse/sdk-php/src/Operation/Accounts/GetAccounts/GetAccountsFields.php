<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Accounts\GetAccounts;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetAccountsFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['accountId', 'email', 'countryCode', 'industryTag', 'timeZone', 'href', 'firstName', 'lastName', 'companyName', 'phone', 'state', 'city', 'street', 'zipCode', 'numberOfEmployees', 'timeFormat'];
    }
}
