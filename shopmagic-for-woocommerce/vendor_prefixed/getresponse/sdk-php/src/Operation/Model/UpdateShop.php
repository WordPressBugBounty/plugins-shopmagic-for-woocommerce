<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class UpdateShop extends BaseModel
{
    /** @var string */
    private $name = self::FIELD_NOT_SET;
    /** @var string */
    private $locale = self::FIELD_NOT_SET;
    /** @var string */
    private $currency = self::FIELD_NOT_SET;
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    public function jsonSerialize(): array
    {
        $data = ['name' => $this->name, 'locale' => $this->locale, 'currency' => $this->currency];
        return $this->filterUnsetFields($data);
    }
}
