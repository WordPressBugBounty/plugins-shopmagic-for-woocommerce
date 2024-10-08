<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class NewTax extends BaseModel
{
    /** @var string */
    private $name;
    /** @var float */
    private $rate;
    /**
     * @param string $name
     * @param float $rate
     */
    public function __construct($name, $rate)
    {
        $this->name = $name;
        $this->rate = $rate;
    }
    public function jsonSerialize(): array
    {
        $data = ['name' => $this->name, 'rate' => $this->rate];
        return $this->filterUnsetFields($data);
    }
}
