<?php

namespace ShopMagicVendor\Getresponse\Sdk\Client\Operation;

/**
 * Class BaseModel
 * @package Getresponse\Sdk\Client\Model
 */
class BaseModel implements \JsonSerializable
{
    const FIELD_NOT_SET = 'field_not_set';
    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [];
    }
    /**
     * @param array $data
     * @return array
     */
    protected function filterUnsetFields(array $data)
    {
        foreach ($data as $key => $value) {
            if (BaseModel::FIELD_NOT_SET === $value) {
                unset($data[$key]);
            }
        }
        return $data;
    }
}
