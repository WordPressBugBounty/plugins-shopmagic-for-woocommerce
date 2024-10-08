<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class TransactionalEmailRecipient extends BaseModel
{
    /** @var string */
    private $email;
    /** @var string */
    private $name = self::FIELD_NOT_SET;
    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    public function jsonSerialize(): array
    {
        $data = ['email' => $this->email, 'name' => $this->name];
        return $this->filterUnsetFields($data);
    }
}
