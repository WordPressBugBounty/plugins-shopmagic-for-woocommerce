<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class NewFromField extends BaseModel
{
    /** @var string */
    private $email;
    /** @var string */
    private $name;
    /**
     * @param string $email
     * @param string $name
     */
    public function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
    }
    public function jsonSerialize(): array
    {
        $data = ['email' => $this->email, 'name' => $this->name];
        return $this->filterUnsetFields($data);
    }
}
