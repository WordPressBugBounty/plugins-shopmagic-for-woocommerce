<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class TriggerCustomEventAttribute extends BaseModel
{
    /** @var string */
    private $name;
    /** @var string */
    private $value;
    /**
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
    public function jsonSerialize(): array
    {
        $data = ['name' => $this->name, 'value' => $this->value];
        return $this->filterUnsetFields($data);
    }
}
