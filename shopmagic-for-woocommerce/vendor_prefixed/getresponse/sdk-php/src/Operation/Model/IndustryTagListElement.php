<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class IndustryTagListElement extends BaseModel
{
    /** @var string */
    private $industryTagId = self::FIELD_NOT_SET;
    /** @var string */
    private $name = self::FIELD_NOT_SET;
    /** @var string */
    private $description = self::FIELD_NOT_SET;
    /**
     * @param string $industryTagId
     */
    public function __construct($industryTagId)
    {
        $this->industryTagId = $industryTagId;
    }
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function jsonSerialize(): array
    {
        $data = ['industryTagId' => $this->industryTagId, 'name' => $this->name, 'description' => $this->description];
        return $this->filterUnsetFields($data);
    }
}
