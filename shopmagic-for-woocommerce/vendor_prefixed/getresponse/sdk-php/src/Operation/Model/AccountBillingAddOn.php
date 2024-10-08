<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class AccountBillingAddOn extends BaseModel
{
    /** @var string */
    private $name = self::FIELD_NOT_SET;
    /** @var string */
    private $price = self::FIELD_NOT_SET;
    /** @var string */
    private $active = self::FIELD_NOT_SET;
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    /**
     * @param string $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
    public function jsonSerialize(): array
    {
        $data = ['name' => $this->name, 'price' => $this->price, 'active' => $this->active];
        return $this->filterUnsetFields($data);
    }
}
