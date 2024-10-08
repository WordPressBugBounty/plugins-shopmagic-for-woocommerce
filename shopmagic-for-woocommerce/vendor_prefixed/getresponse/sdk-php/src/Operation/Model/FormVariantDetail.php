<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class FormVariantDetail extends BaseModel
{
    /** @var string */
    private $variant = self::FIELD_NOT_SET;
    /** @var string */
    private $variantName = self::FIELD_NOT_SET;
    /** @var string */
    private $winner = self::FIELD_NOT_SET;
    /** @var string */
    private $status = self::FIELD_NOT_SET;
    /** @var string */
    private $createdOn = self::FIELD_NOT_SET;
    /** @var \Getresponse\Sdk\Operation\Model\FormStatistics */
    private $statistics = self::FIELD_NOT_SET;
    /**
     * @param string $variant
     */
    public function setVariant($variant)
    {
        $this->variant = $variant;
    }
    /**
     * @param string $variantName
     */
    public function setVariantName($variantName)
    {
        $this->variantName = $variantName;
    }
    /**
     * @param string $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }
    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    /**
     * @param string $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }
    /**
     * @param \Getresponse\Sdk\Operation\Model\FormStatistics $statistics
     */
    public function setStatistics(FormStatistics $statistics)
    {
        $this->statistics = $statistics;
    }
    public function jsonSerialize(): array
    {
        $data = ['variant' => $this->variant, 'variantName' => $this->variantName, 'winner' => $this->winner, 'status' => $this->status, 'createdOn' => $this->createdOn, 'statistics' => $this->statistics];
        return $this->filterUnsetFields($data);
    }
}
