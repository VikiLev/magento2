<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Minutes implements OptionSourceInterface
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

        $options = [];
        foreach (range(0, 59) as $item) {
            if (strlen($item) < 2) {
                $item = "0" . $item;
            }
            $options[] = ['label' => (string)$item, 'value' => $item];
        }

        $this->options = $options;

        return $this->options;
    }
}
