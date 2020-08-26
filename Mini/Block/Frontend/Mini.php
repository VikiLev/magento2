<?php

namespace Web\Mini\Block\Frontend;
use Magento\Catalog\Block\ShortcutButtons;
use Magento\Framework\View\Element\Template;
Use Magento\Catalog\Block\ShortcutInterface;
use Web\Mini\Helper\Data;

class Mini extends Template implements ShortcutInterface
{
    const ALIAS_ELEMENT_INDEX = 'alias';
    protected $helperData;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    const TIMEOUT = 'web_mini/general/timeout';

    public function __construct(
        Data $helperData,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->helperData = $helperData;
    }
    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return $this->getData(self::ALIAS_ELEMENT_INDEX);
    }

    public function getConfigTime()
    {
        return $this->helperData->getConfig();
    }


}
