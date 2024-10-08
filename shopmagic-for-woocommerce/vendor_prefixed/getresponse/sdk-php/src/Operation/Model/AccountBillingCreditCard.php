<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class AccountBillingCreditCard extends BaseModel
{
    /** @var string */
    private $number = self::FIELD_NOT_SET;
    /** @var string */
    private $expirationDate = self::FIELD_NOT_SET;
    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }
    /**
     * @param string $expirationDate
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }
    public function jsonSerialize(): array
    {
        $data = ['number' => $this->number, 'expirationDate' => $this->expirationDate];
        return $this->filterUnsetFields($data);
    }
}
