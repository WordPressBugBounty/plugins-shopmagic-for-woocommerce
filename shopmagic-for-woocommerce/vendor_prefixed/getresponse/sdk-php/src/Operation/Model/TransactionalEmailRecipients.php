<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

use ShopMagicVendor\Getresponse\Sdk\Client\Operation\BaseModel;
class TransactionalEmailRecipients extends BaseModel
{
    /** @var TransactionalEmailRecipientTo */
    private $to;
    /** @var TransactionalEmailRecipient[] */
    private $cc = self::FIELD_NOT_SET;
    /** @var TransactionalEmailRecipient[] */
    private $bcc = self::FIELD_NOT_SET;
    /**
     * @param TransactionalEmailRecipientTo $to
     */
    public function __construct(TransactionalEmailRecipientTo $to)
    {
        $this->to = $to;
    }
    /**
     * @param TransactionalEmailRecipient[] $cc
     */
    public function setCc(array $cc)
    {
        $this->cc = $cc;
    }
    /**
     * @param TransactionalEmailRecipient[] $bcc
     */
    public function setBcc(array $bcc)
    {
        $this->bcc = $bcc;
    }
    public function jsonSerialize(): array
    {
        $data = ['to' => $this->to, 'cc' => $this->cc, 'bcc' => $this->bcc];
        return $this->filterUnsetFields($data);
    }
}
