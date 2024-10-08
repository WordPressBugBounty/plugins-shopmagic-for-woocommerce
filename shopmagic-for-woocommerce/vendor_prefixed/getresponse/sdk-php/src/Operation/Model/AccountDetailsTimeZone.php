<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class AccountDetailsTimeZone extends BaseModel
{
    /** @var string */
    private $name = self::FIELD_NOT_SET;
    /** @var string */
    private $offset = self::FIELD_NOT_SET;
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @param string $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
    public function jsonSerialize(): array
    {
        $data = ['name' => $this->name, 'offset' => $this->offset];
        return $this->filterUnsetFields($data);
    }
}
