<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class NewFile extends BaseModel
{
    /** @var string */
    private $content;
    /** @var string */
    private $name;
    /** @var string */
    private $extension;
    /** @var FolderShort */
    private $folder;
    /**
     * @param string $content
     * @param string $name
     * @param string $extension
     * @param FolderShort $folder
     */
    public function __construct($content, $name, $extension, FolderShort $folder = null)
    {
        $this->content = $content;
        $this->name = $name;
        $this->extension = $extension;
        $this->folder = $folder;
    }
    public function jsonSerialize(): array
    {
        $data = ['content' => $this->content, 'name' => $this->name, 'extension' => $this->extension, 'folder' => $this->folder];
        return $this->filterUnsetFields($data);
    }
}
