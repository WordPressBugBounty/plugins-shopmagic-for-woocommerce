<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class CustomDateRange extends BaseModel
{
    /** @var string */
    private $from;
    /** @var string */
    private $to;
    /**
     * @param string $from
     * @param string $to
     */
    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    public function jsonSerialize(): array
    {
        $data = ['from' => $this->from, 'to' => $this->to];
        return $this->filterUnsetFields($data);
    }
}
