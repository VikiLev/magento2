<?php


namespace Web\LoginAsCustomer\Block\Adminhtml\Order;


class View extends \Magento\Sales\Block\Adminhtml\Order\View
{

    protected $customer;
    protected $LoginCustomer;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Model\Config $salesConfig,
        \Magento\Sales\Helper\Reorder $reorderHelper,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customer,
        \Web\LoginAsCustomer\Model\LoginAsCustomer $LoginCustomer,
        array $data = []
    )
    {
        $this->customer = $customer;
        $this->LoginCustomer = $LoginCustomer;
        parent::__construct($context, $registry, $salesConfig, $reorderHelper, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'order_id';
        $this->_controller = 'adminhtml_order';
        $this->_mode = 'view';
        parent::_construct();
        $this->setId('sales_order_view');
        $order = $this->getOrder();


        $checkCustomerId = $this->getOrder()->getCustomerId();
        if ($checkCustomerId) {
            {
                $urlData = $this->_urlBuilder->getUrl(
                    'loginascustomer/loginascustomer/login',
                    ['customer_id' => $checkCustomerId, 'login_from' => 3]
                );
                $this->buttonList->add(
                    'loginascustomer',
                    [
                        'label' => __('Login As Customer'),
                        'class' => 'loginascustomer',
                        'onclick' => 'window.open(\'' . $urlData . '\', \'_blank\')'
                    ]
                );
            }
        }
    }

}
