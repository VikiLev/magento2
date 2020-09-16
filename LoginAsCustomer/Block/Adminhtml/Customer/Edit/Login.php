<?php


namespace Web\LoginAsCustomer\Block\Adminhtml\Customer\Edit;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Web\LoginAsCustomer\Model\Connector;


class Login extends GenericButton implements ButtonProviderInterface
{

    protected $authorization;
    protected $scopeConfig;
    protected $urlBuilder;
    protected $connector;


    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        Connector $connector
    ) {
        parent::__construct($context, $registry);
        $this->authorization = $context->getAuthorization();
        $this->scopeConfig = $context->getScopeConfig();
        $this->urlBuilder = $context->getUrlBuilder();
        $this->connector = $connector;
    }


    public function getButtonData()
    {
        $customerId = $this->getCustomerId();
        $data = [];

        $canModify = $customerId && $this->authorization->isAllowed('Web_LoginAsCustomer::CustomerView');
        $loginAsCustomerEnabled = $this->connector->getCustomerLoginEnable();
        $customerDetailLoginEnabled = $this->connector->getCustomerViewPage();

        if ($canModify == "1" && $loginAsCustomerEnabled == "1" && $customerDetailLoginEnabled == "1") {
            $urlData = $this->urlBuilder->getUrl(
                'loginascustomer/loginascustomer/login',
                ['customer_id' => $customerId, 'login_from' => 2]
            );

            $data = [
                'label' =>  __('LoginAsCustomer As Customer'),
                'class' => 'login login-button',
                'on_click' => 'window.open(\'' . $urlData . '\', \'_blank\')'
            ];
        }
        return $data;
    }

    public function getInvalidateTokenUrl()
    {
        return $this->getUrl('loginascustomer/login/login', ['customer_id' => $this->getCustomerId()]);
    }
}
