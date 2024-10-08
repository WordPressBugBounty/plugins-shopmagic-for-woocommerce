<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class SimpleTaxDetails extends BaseModel
{
    /** @var string */
    private $taxId = self::FIELD_NOT_SET;
    /** @var string */
    private $href = self::FIELD_NOT_SET;
    /** @var string */
    private $name = self::FIELD_NOT_SET;
    /** @var string */
    private $rate = self::FIELD_NOT_SET;
    /**
     * @param string $taxId
     * @param string $name
     * @param string $rate
     */
    public function __construct($taxId, $name, $rate)
    {
        $this->taxId = $taxId;
        $this->name = $name;
        $this->rate = $rate;
    }
    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }
    public function jsonSerialize(): array
    {
        $data = ['taxId' => $this->taxId, 'href' => $this->href, 'name' => $this->name, 'rate' => $this->rate];
        return $this->filterUnsetFields($data);
    }
}
