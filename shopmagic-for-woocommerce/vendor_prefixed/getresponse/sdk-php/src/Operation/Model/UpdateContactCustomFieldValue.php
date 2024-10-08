<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class UpdateContactCustomFieldValue extends BaseModel
{
    /** @var string */
    private $customFieldId = self::FIELD_NOT_SET;
    /** @var string */
    private $value = self::FIELD_NOT_SET;
    /**
     * @param string $customFieldId
     * @param string $value
     */
    public function __construct($customFieldId, $value)
    {
        $this->customFieldId = $customFieldId;
        $this->value = $value;
    }
    public function jsonSerialize(): array
    {
        $data = ['customFieldId' => $this->customFieldId, 'value' => $this->value];
        return $this->filterUnsetFields($data);
    }
}
