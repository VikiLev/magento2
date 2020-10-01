<?php


namespace Web\LoginAsCustomer\Block\Adminhtml\Customer\Edit;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class Login extends GenericButton implements ButtonProviderInterface
{

    protected $authorization;
    protected $scopeConfig;
    protected $urlBuilder;
    protected $connector;


    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry

    ) {
        parent::__construct($context, $registry);
        $this->authorization = $context->getAuthorization();
        $this->scopeConfig = $context->getScopeConfig();
        $this->urlBuilder = $context->getUrlBuilder();

    }

    public function getButtonData()
    {
        $customerId = $this->getCustomerId();
        $data = [];

            $urlData = $this->urlBuilder->getUrl(
                'loginascustomer/loginascustomer/login',
                ['customer_id' => $customerId, 'login_from' => 2]
            );

            $data = [
                'label' =>  __('Login As Customer'),
                'class' => 'login login-button',
                'on_click' => 'window.open(\'' . $urlData . '\', \'_blank\')'
            ];

        return $data;
    }

    public function getInvalidateTokenUrl()
    {
        return $this->getUrl('loginascustomer/login/login', ['customer_id' => $this->getCustomerId()]);
    }
}
