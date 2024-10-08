<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class NewSuppression extends BaseModel
{
    /** @var string */
    private $name;
    /** @var array */
    private $masks = self::FIELD_NOT_SET;
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
    /**
     * @param array $masks
     */
    public function setMasks(array $masks)
    {
        $this->masks = $masks;
    }
    public function jsonSerialize(): array
    {
        $data = ['name' => $this->name, 'masks' => $this->masks];
        return $this->filterUnsetFields($data);
    }
}
