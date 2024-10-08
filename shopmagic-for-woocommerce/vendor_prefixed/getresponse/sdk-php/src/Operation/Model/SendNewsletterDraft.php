<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class SendNewsletterDraft extends BaseModel
{
    /** @var string */
    private $messageId;
    /** @var string */
    private $sendOn = self::FIELD_NOT_SET;
    /** @var NewsletterSendSettings */
    private $sendSettings;
    /**
     * @param string $messageId
     * @param NewsletterSendSettings $sendSettings
     */
    public function __construct($messageId, NewsletterSendSettings $sendSettings)
    {
        $this->messageId = $messageId;
        $this->sendSettings = $sendSettings;
    }
    /**
     * @param string $sendOn
     */
    public function setSendOn($sendOn)
    {
        $this->sendOn = $sendOn;
    }
    public function jsonSerialize(): array
    {
        $data = ['messageId' => $this->messageId, 'sendOn' => $this->sendOn, 'sendSettings' => $this->sendSettings];
        return $this->filterUnsetFields($data);
    }
}
