<?php

namespace Web\UrlRewrite\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 * @package Web\UrlRewrite\Helper
 */
class Data extends AbstractHelper
{
    public function getPrefix(){
        return $this->scopeConfig->getValue('web_urlrewrite/general/prefix');
    }
    public function getPrefixCategory(){
        return $this->scopeConfig->getValue('web_urlrewrite/general/prefix_category');
    }
}



