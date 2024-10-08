<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class FromFieldReference extends BaseModel
{
    /** @var string */
    private $fromFieldId;
    /**
     * @param string $fromFieldId
     */
    public function __construct($fromFieldId)
    {
        $this->fromFieldId = $fromFieldId;
    }
    public function jsonSerialize(): array
    {
        $data = ['fromFieldId' => $this->fromFieldId];
        return $this->filterUnsetFields($data);
    }
}
