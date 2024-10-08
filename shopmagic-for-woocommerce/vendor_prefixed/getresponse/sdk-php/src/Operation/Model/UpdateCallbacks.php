<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class UpdateCallbacks extends BaseModel
{
    /** @var string */
    private $url = self::FIELD_NOT_SET;
    /** @var CallbackActions */
    private $actions = self::FIELD_NOT_SET;
    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    /**
     * @param CallbackActions $actions
     */
    public function setActions(CallbackActions $actions)
    {
        $this->actions = $actions;
    }
    public function jsonSerialize(): array
    {
        $data = ['url' => $this->url, 'actions' => $this->actions];
        return $this->filterUnsetFields($data);
    }
}
