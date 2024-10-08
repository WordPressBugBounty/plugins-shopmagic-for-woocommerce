<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Autoresponders\GetAutoresponders;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\ValueList;
class GetAutorespondersFields extends ValueList
{
    /**
     * @return array
     */
    public function getAllowedValues()
    {
        return ['autoresponderId', 'href', 'name', 'subject', 'campaignId', 'status', 'editor', 'fromField', 'replyTo', 'content', 'flags', 'sendSettings', 'triggerSettings', 'statistics', 'createdOn'];
    }
}
