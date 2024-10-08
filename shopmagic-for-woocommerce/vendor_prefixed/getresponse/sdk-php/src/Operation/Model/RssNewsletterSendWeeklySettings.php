<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

class RssNewsletterSendWeeklySettings extends RssNewsletterSendSettings
{
    /** @var int */
    private $sendAtHour;
    /** @var string */
    private $sendAtWeekDay;
    /**
     * @param string $filter
     * @param int $sendAtHour
     * @param string $sendAtWeekDay
     */
    public function __construct($filter, $sendAtHour, $sendAtWeekDay)
    {
        parent::__construct('weekly', $filter);
        $this->sendAtHour = $sendAtHour;
        $this->sendAtWeekDay = $sendAtWeekDay;
    }
    public function jsonSerialize(): array
    {
        $data = ['sendAtHour' => $this->sendAtHour, 'sendAtWeekDay' => $this->sendAtWeekDay];
        return array_merge(parent::jsonSerialize(), $this->filterUnsetFields($data));
    }
}
