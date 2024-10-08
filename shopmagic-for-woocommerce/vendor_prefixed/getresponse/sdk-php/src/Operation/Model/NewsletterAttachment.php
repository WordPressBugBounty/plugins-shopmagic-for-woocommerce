<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class NewsletterAttachment extends BaseModel
{
    /** @var string */
    private $fileName = self::FIELD_NOT_SET;
    /** @var string */
    private $content = self::FIELD_NOT_SET;
    /** @var string */
    private $mimeType = self::FIELD_NOT_SET;
    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }
    public function jsonSerialize(): array
    {
        $data = ['fileName' => $this->fileName, 'content' => $this->content, 'mimeType' => $this->mimeType];
        return $this->filterUnsetFields($data);
    }
}
