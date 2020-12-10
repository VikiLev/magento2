<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Source;

use Magento\Framework\Data\OptionSourceInterface;
use W4PLEGO\BaseIntegration\Api\Data\ConnectorInterface;

class Connector implements OptionSourceInterface
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
            ['label' => ConnectorInterface::GUZZLE, 'value' => ConnectorInterface::GUZZLE],
            ['label' => ConnectorInterface::CURL, 'value' => ConnectorInterface::CURL]
        ];

        $this->options = $options;

        return $this->options;
    }
}
