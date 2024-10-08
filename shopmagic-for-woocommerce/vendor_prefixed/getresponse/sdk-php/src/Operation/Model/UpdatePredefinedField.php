<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class UpdatePredefinedField extends BaseModel
{
    /** @var string */
    private $value;
    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
    public function jsonSerialize(): array
    {
        $data = ['value' => $this->value];
        return $this->filterUnsetFields($data);
    }
}
