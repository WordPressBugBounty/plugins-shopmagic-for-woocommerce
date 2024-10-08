<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class NewPredefinedField extends BaseModel
{
    /** @var string */
    private $name;
    /** @var string */
    private $value;
    /** @var CampaignReference */
    private $campaign;
    /**
     * @param string $name
     * @param string $value
     * @param CampaignReference $campaign
     */
    public function __construct($name, $value, CampaignReference $campaign)
    {
        $this->name = $name;
        $this->value = $value;
        $this->campaign = $campaign;
    }
    public function jsonSerialize(): array
    {
        $data = ['name' => $this->name, 'value' => $this->value, 'campaign' => $this->campaign];
        return $this->filterUnsetFields($data);
    }
}
