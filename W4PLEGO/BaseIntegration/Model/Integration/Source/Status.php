<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Source;

use Magento\Framework\Data\OptionSourceInterface;
use W4PLEGO\BaseIntegration\Model\Integration;

class Status implements OptionSourceInterface
{
    /**
     * Options
     *
     * @var array
     */
    protected $options;

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $options = [
            ['label' => '', 'value' => ''],
            ['label' => Integration::STATUS_PENDING, 'value' => Integration::STATUS_PENDING],
            ['label' => Integration::STATUS_DISABLED, 'value' => Integration::STATUS_DISABLED]
        ];

        $this->options = $options;

        return $this->options;
    }
}
