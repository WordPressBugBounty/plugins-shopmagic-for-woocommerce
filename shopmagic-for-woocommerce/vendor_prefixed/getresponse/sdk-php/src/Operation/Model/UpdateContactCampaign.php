<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class UpdateContactCampaign extends BaseModel
{
    /** @var string */
    private $campaignId = self::FIELD_NOT_SET;
    /**
     * @param string $campaignId
     */
    public function __construct($campaignId)
    {
        $this->campaignId = $campaignId;
    }
    public function jsonSerialize(): array
    {
        $data = ['campaignId' => $this->campaignId];
        return $this->filterUnsetFields($data);
    }
}
