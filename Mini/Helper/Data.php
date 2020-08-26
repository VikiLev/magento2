<?php

namespace Web\Mini\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */

    const TIMEOUT = 'web_mini/general/timeout';

    public function getConfig()
    {
        return $this->scopeConfig->getValue(self::TIMEOUT);

    }
}
