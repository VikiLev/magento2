<?php

namespace Web\HidePrice\Helper;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 * @package Web\HidePrice\Helper
 */
class Data extends AbstractHelper
{
    public $customerSession;
    public $httpContext;
    public $session;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Magento\Framework\App\Http\Context $httpContext
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
    }


    public function isLog()
    {
        return $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    public function isLoggedIn()
    {
        $session = $this->customerSession->create();
        if ($session->isLoggedIn()){
            return true;
        }
    }

    public function getIsEnable(){
        return $this->scopeConfig->getValue('web_hideprice/general/enabled');
    }



}
