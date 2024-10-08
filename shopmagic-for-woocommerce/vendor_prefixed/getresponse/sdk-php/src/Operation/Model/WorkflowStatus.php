<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class WorkflowStatus extends BaseModel
{
    /** @var string */
    private $status = self::FIELD_NOT_SET;
    /**
     * @param string $status
     */
    public function __construct($status)
    {
        $this->status = $status;
    }
    public function jsonSerialize(): array
    {
        $data = ['status' => $this->status];
        return $this->filterUnsetFields($data);
    }
}
