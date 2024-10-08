<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class TagDetails extends BaseModel
{
    /** @var string */
    private $tagId = self::FIELD_NOT_SET;
    /** @var string */
    private $name = self::FIELD_NOT_SET;
    /** @var string */
    private $color = self::FIELD_NOT_SET;
    /** @var string */
    private $createdAt = self::FIELD_NOT_SET;
    /**
     * @param string $tagId
     * @param string $name
     * @param string $createdAt
     */
    public function __construct($tagId, $name, $createdAt)
    {
        $this->tagId = $tagId;
        $this->name = $name;
        $this->createdAt = $createdAt;
    }
    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
    public function jsonSerialize(): array
    {
        $data = ['tagId' => $this->tagId, 'name' => $this->name, 'color' => $this->color, 'createdAt' => $this->createdAt];
        return $this->filterUnsetFields($data);
    }
}
