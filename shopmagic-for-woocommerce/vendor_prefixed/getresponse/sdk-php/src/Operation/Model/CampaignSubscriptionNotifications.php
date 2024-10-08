<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class CampaignSubscriptionNotifications extends BaseModel
{
    /** @var StatusEnum */
    private $status = self::FIELD_NOT_SET;
    /** @var FromFieldReference[] */
    private $recipients = self::FIELD_NOT_SET;
    /**
     * @param StatusEnum $status
     */
    public function setStatus(StatusEnum $status)
    {
        $this->status = $status;
    }
    /**
     * @param FromFieldReference[] $recipients
     */
    public function setRecipients(array $recipients)
    {
        $this->recipients = $recipients;
    }
    public function jsonSerialize(): array
    {
        $data = ['status' => $this->status, 'recipients' => $this->recipients];
        return $this->filterUnsetFields($data);
    }
}
