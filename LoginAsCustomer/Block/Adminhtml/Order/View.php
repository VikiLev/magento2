<?php


namespace Web\LoginAsCustomer\Block\Adminhtml\Order;

use Magento\Framework\AuthorizationInterface;

class View extends \Magento\Sales\Block\Adminhtml\Order\View
{

    protected $customer;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Model\Config $salesConfig,
        \Magento\Sales\Helper\Reorder $reorderHelper,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customer,
        array $data = []
    ) {
        $this->customer = $customer;
        parent::__construct($context, $registry, $salesConfig, $reorderHelper, $data);
    }
    protected function _construct()
    {
        $this->_objectId = 'order_id';
        $this->_controller = 'adminhtml_order';
        $this->_mode = 'view';
        parent::_construct();
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
        $this->setId('sales_order_view');
        $order = $this->getOrder();


        if (!$order) {
            return;
        }

        $hidden = $this->_authorization->isAllowed('Web_LoginAsCustomer::OrderGrid');
        $checkCustomerId = $this->getOrder()->getCustomerId();

        try {
                   $this->customer->getById($checkCustomerId)->getId();
        } catch (\Exception $e) {
                    return;
        }

        $loginAsCustomerEnabled = $this->_scopeConfig->getValue(
            'web/general/login_as_customer_enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $orderViewPage = $this->_scopeConfig->getValue(
            'web/button_visibility/order_view_page',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if ($loginAsCustomerEnabled == "1"
        && $orderViewPage == "1"
        && isset($checkCustomerId)
        && $hidden == "1"

        ) {
            $urlData = $this->_urlBuilder->getUrl(
                'loginascustomer/loginascustomer/login',
                ['customer_id' => $checkCustomerId, 'login_from' => 3]
            );
            $this->buttonList->add(
                'loginascustomer',
                [
                    'label' => __('LoginAsCustomer As Customer'),
                    'class' => 'loginascustomer',
                    'onclick' => 'window.open(\'' . $urlData . '\', \'_blank\')'
                ]
            );
        }
    }
}
