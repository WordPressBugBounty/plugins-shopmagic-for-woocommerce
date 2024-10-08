<?php

namespace ShopMagicVendor\Getresponse\Sdk\Operation\Model;

class CrmCondition extends ConditionType
{
    /** @var string */
    private $pipelineScope;
    /** @var string */
    private $stageScope;
    /**
     * @param string $pipelineScope
     * @param string $stageScope
     */
    public function __construct($pipelineScope, $stageScope)
    {
        parent::__construct('crm');
        $this->pipelineScope = $pipelineScope;
        $this->stageScope = $stageScope;
    }
    public function jsonSerialize(): array
    {
        $data = ['pipelineScope' => $this->pipelineScope, 'stageScope' => $this->stageScope];
        return array_merge(parent::jsonSerialize(), $this->filterUnsetFields($data));
    }
}
