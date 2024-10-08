<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\RssNewsletters\GetRssNewsletter;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\QueryOperation;
use ShopMagicVendor\Getresponse\Sdk\OperationVersionTrait;
class GetRssNewsletter extends QueryOperation
{
    use OperationVersionTrait;
    public const METHOD_URL = '/v3/rss-newsletters/{rssNewsletterId}';
    /** @var string */
    private $rssNewsletterId;
    /** @var GetRssNewsletterFields */
    private $fields;
    /**
     * @param string $rssNewsletterId
     */
    public function __construct($rssNewsletterId)
    {
        $this->rssNewsletterId = $rssNewsletterId;
    }
    /**
     * @return string
     */
    public function buildUrlFromTemplate()
    {
        return str_ireplace(['{rssNewsletterId}'], [$this->rssNewsletterId], self::METHOD_URL);
    }
    /**
     * @param GetRssNewsletterFields $fields
     * @return $this
     */
    public function setFields(GetRssNewsletterFields $fields)
    {
        $this->fields = $fields;
        return $this;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        $extra = $this->getFieldsParameterArray($this->fields);
        return $this->buildUrlFromTemplate() . $this->buildQueryString(null, null, $extra);
    }
}
