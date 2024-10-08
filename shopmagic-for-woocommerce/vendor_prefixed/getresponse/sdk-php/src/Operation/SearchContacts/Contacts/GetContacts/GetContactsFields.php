<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\SearchContacts\Contacts\GetContacts;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetContactsFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['contactId', 'name', 'email', 'origin', 'dayOfCycle', 'createdOn', 'campaign', 'score', 'reason'];
    }
}
