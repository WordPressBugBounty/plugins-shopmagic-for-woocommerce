<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

class SectionCustomSubscriptionDate extends SearchContactSection
{
    /** @var CustomDateRange */
    private $customDate;
    /**
     * @param array $campaignIdsList
     * @param string $logicOperator
     * @param array $subscriberCycle
     * @param CustomDateRange $customDate
     */
    public function __construct(array $campaignIdsList, $logicOperator, array $subscriberCycle, CustomDateRange $customDate)
    {
        parent::__construct($campaignIdsList, $logicOperator, $subscriberCycle, 'custom');
        $this->customDate = $customDate;
    }
    public function jsonSerialize(): array
    {
        $data = ['customDate' => $this->customDate];
        return array_merge(parent::jsonSerialize(), $this->filterUnsetFields($data));
    }
}
