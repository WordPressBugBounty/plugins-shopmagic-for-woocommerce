<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class TransactionalEmailAttachment extends BaseModel
{
    /** @var string */
    private $fileName;
    /** @var string */
    private $mimeType;
    /** @var string */
    private $content;
    /**
     * @param string $fileName
     * @param string $mimeType
     * @param string $content
     */
    public function __construct($fileName, $mimeType, $content)
    {
        $this->fileName = $fileName;
        $this->mimeType = $mimeType;
        $this->content = $content;
    }
    public function jsonSerialize(): array
    {
        $data = ['fileName' => $this->fileName, 'mimeType' => $this->mimeType, 'content' => $this->content];
        return $this->filterUnsetFields($data);
    }
}
