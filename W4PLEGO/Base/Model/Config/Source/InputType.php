<?php

namespace W4PLEGO\Base\Model\Config\Source;

/**
 * Class InputType
 *
 * @package W4PLEGO\Base\Model\Config\Source
 */
class InputType implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * InputType constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->options;
    }
}
