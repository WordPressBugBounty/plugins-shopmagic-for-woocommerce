<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class UpsertContactCustomFields extends BaseModel
{
    /** @var NewContactCustomFieldValue[] */
    private $customFieldValues;
    /**
     * @param NewContactCustomFieldValue[] $customFieldValues
     */
    public function __construct(array $customFieldValues)
    {
        $this->customFieldValues = $customFieldValues;
    }
    public function jsonSerialize(): array
    {
        $data = ['customFieldValues' => $this->customFieldValues];
        return $this->filterUnsetFields($data);
    }
}
