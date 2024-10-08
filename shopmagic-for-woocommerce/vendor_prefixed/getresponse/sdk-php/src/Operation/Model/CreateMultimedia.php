<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class CreateMultimedia extends BaseModel
{
    /** @var string */
    private $file = self::FIELD_NOT_SET;
    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
    public function jsonSerialize(): array
    {
        $data = ['file' => $this->file];
        return $this->filterUnsetFields($data);
    }
}
