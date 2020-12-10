<?php

namespace W4PLEGO\BaseIntegration\Block\Adminhtml\Integration\Grid;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

class View extends Template
{
    /**
     * @var string
     */
    public $_template = 'W4PLEGO_BaseIntegration::integration/grid/run_view.phtml';

    /**
     * View constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }
}
