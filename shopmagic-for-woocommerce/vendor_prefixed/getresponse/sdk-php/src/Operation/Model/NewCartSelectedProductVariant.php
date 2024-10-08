<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class NewCartSelectedProductVariant extends BaseModel
{
    /** @var string */
    private $variantId;
    /** @var int */
    private $quantity;
    /** @var float */
    private $price;
    /** @var float */
    private $priceTax;
    /**
     * @param string $variantId
     * @param int $quantity
     * @param float $price
     * @param float $priceTax
     */
    public function __construct($variantId, $quantity, $price, $priceTax)
    {
        $this->variantId = $variantId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->priceTax = $priceTax;
    }
    public function jsonSerialize(): array
    {
        $data = ['variantId' => $this->variantId, 'quantity' => $this->quantity, 'price' => $this->price, 'priceTax' => $this->priceTax];
        return $this->filterUnsetFields($data);
    }
}
