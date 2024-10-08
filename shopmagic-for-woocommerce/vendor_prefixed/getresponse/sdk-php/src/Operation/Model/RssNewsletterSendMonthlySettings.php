<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

class RssNewsletterSendMonthlySettings extends RssNewsletterSendSettings
{
    /** @var int */
    private $sendAtHour;
    /** @var int */
    private $sendAtMonthDay;
    /**
     * @param string $filter
     * @param int $sendAtHour
     * @param int $sendAtMonthDay
     */
    public function __construct($filter, $sendAtHour, $sendAtMonthDay)
    {
        parent::__construct('monthly', $filter);
        $this->sendAtHour = $sendAtHour;
        $this->sendAtMonthDay = $sendAtMonthDay;
    }
    public function jsonSerialize(): array
    {
        $data = ['sendAtHour' => $this->sendAtHour, 'sendAtMonthDay' => $this->sendAtMonthDay];
        return array_merge(parent::jsonSerialize(), $this->filterUnsetFields($data));
    }
}
