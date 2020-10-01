<?php

namespace Web\Rewrite\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;


class Data extends AbstractHelper
{

    public function getPrefix(){
        return $this->scopeConfig->getValue('web_rewrite/general/prefix');
    }

    public function getPrefixCategory(){
        return $this->scopeConfig->getValue('web_rewrite/general/prefix_category');
    }
}



