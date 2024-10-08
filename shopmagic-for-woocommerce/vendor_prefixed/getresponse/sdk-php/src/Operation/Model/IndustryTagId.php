<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class IndustryTagId extends BaseModel
{
    /** @var string */
    private $industryTagId = self::FIELD_NOT_SET;
    /**
     * @param string $industryTagId
     */
    public function setIndustryTagId($industryTagId)
    {
        $this->industryTagId = $industryTagId;
    }
    public function jsonSerialize(): array
    {
        $data = ['industryTagId' => $this->industryTagId];
        return $this->filterUnsetFields($data);
    }
}
