<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class ContactDetails extends BaseModel
{
    /** @var string */
    private $contactId = self::FIELD_NOT_SET;
    /** @var string */
    private $href = self::FIELD_NOT_SET;
    /** @var string */
    private $name = self::FIELD_NOT_SET;
    /** @var string */
    private $email = self::FIELD_NOT_SET;
    /** @var string */
    private $note = self::FIELD_NOT_SET;
    /** @var string */
    private $origin = self::FIELD_NOT_SET;
    /** @var string */
    private $dayOfCycle = self::FIELD_NOT_SET;
    /** @var string */
    private $changedOn = self::FIELD_NOT_SET;
    /** @var string */
    private $timeZone = self::FIELD_NOT_SET;
    /** @var string */
    private $ipAddress = self::FIELD_NOT_SET;
    /** @var string */
    private $activities = self::FIELD_NOT_SET;
    /** @var \Getresponse\Sdk\Operation\Model\ShortCampaign */
    private $campaign = self::FIELD_NOT_SET;
    /** @var string */
    private $createdOn = self::FIELD_NOT_SET;
    /** @var \Getresponse\Sdk\Operation\Model\ContactGeolocation */
    private $geolocation = self::FIELD_NOT_SET;
    /** @var \Getresponse\Sdk\Operation\Model\TagListElement[] */
    private $tags = self::FIELD_NOT_SET;
    /** @var \Getresponse\Sdk\Operation\Model\ContactCustomFieldListElement[] */
    private $customFieldValues = self::FIELD_NOT_SET;
    /** @var string */
    private $scoring = self::FIELD_NOT_SET;
    /**
     * @param string $contactId
     * @param string $href
     * @param string $origin
     * @param string $activities
     * @param \Getresponse\Sdk\Operation\Model\ShortCampaign $campaign
     * @param string $createdOn
     */
    public function __construct($contactId, $href, $origin, $activities, ShortCampaign $campaign, $createdOn)
    {
        $this->contactId = $contactId;
        $this->href = $href;
        $this->origin = $origin;
        $this->activities = $activities;
        $this->campaign = $campaign;
        $this->createdOn = $createdOn;
    }
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
    /**
     * @param string $dayOfCycle
     */
    public function setDayOfCycle($dayOfCycle)
    {
        $this->dayOfCycle = $dayOfCycle;
    }
    /**
     * @param string $changedOn
     */
    public function setChangedOn($changedOn)
    {
        $this->changedOn = $changedOn;
    }
    /**
     * @param string $timeZone
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }
    /**
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }
    /**
     * @param \Getresponse\Sdk\Operation\Model\ContactGeolocation $geolocation
     */
    public function setGeolocation(ContactGeolocation $geolocation)
    {
        $this->geolocation = $geolocation;
    }
    /**
     * @param \Getresponse\Sdk\Operation\Model\TagListElement[] $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }
    /**
     * @param \Getresponse\Sdk\Operation\Model\ContactCustomFieldListElement[] $customFieldValues
     */
    public function setCustomFieldValues(array $customFieldValues)
    {
        $this->customFieldValues = $customFieldValues;
    }
    /**
     * @param string $scoring
     */
    public function setScoring($scoring)
    {
        $this->scoring = $scoring;
    }
    public function jsonSerialize(): array
    {
        $data = ['contactId' => $this->contactId, 'href' => $this->href, 'name' => $this->name, 'email' => $this->email, 'note' => $this->note, 'origin' => $this->origin, 'dayOfCycle' => $this->dayOfCycle, 'changedOn' => $this->changedOn, 'timeZone' => $this->timeZone, 'ipAddress' => $this->ipAddress, 'activities' => $this->activities, 'campaign' => $this->campaign, 'createdOn' => $this->createdOn, 'geolocation' => $this->geolocation, 'tags' => $this->tags, 'customFieldValues' => $this->customFieldValues, 'scoring' => $this->scoring];
        return $this->filterUnsetFields($data);
    }
}
