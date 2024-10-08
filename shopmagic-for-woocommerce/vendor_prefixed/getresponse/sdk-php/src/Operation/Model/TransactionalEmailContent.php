<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class TransactionalEmailContent extends BaseModel
{
    /** @var string */
    private $plain = self::FIELD_NOT_SET;
    /** @var string */
    private $html = self::FIELD_NOT_SET;
    /**
     * @param string $plain
     */
    public function setPlain($plain)
    {
        $this->plain = $plain;
    }
    /**
     * @param string $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }
    public function jsonSerialize(): array
    {
        $data = ['plain' => $this->plain, 'html' => $this->html];
        return $this->filterUnsetFields($data);
    }
}
