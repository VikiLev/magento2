<?php

namespace Web\LoginAsCustomer\Controller\Adminhtml\LoginAsCustomer;

class Login extends \Magento\Backend\App\Action
{

    public $LoginCustomer;
    public $Session;
    public $StoreManager;
    public $Url;
    public $random;
    public $model;
    public $authorization;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Web\LoginAsCustomer\Model\LoginAsCustomer $LoginCustomer,
        \Magento\Backend\Model\Auth\Session $Session,
        \Magento\Store\Model\StoreManagerInterface $StoreManager,
        \Magento\Framework\Url $Url,
        \Magento\Framework\Math\Random $random,
        \Web\LoginAsCustomer\Model\LoginAsCustomerFactory $model

    )
    {
        $this->authorization = $context->getAuthorization();
        $this->LoginCustomer = $LoginCustomer;
        $this->Session = $Session;
        $this->StoreManager = $StoreManager;
        $this->Url = $Url;
        $this->model = $model;
        $this->random = $random;

        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Web_LoginAsCustomer::CustomerView');
    }
    public function execute()
    {
        $customerId = (int)$this->getRequest()->getParam('customer_id');
        $login = $this->LoginCustomer->setCustomerId($customerId);

        $customer = $login->getCustomer();

        if (!$customer->getId()) {
            $this->messageManager->addErrorMessage(__('This is not valid customer/ Customer not found'));
            $this->_redirect('customer/index/index');
            return;
        }
        $user = $this->Session->getUser();

        $adminId = $user->getId();
        $adminUsername = $user->getusername();
        $customerEmail = $customer->getEmail();
        $customerName = $customer->getName();
        $customerStoreId = $customer->getData('store_id');



//        $login->generate(
//            $adminUsername,
//            $customerEmail,
//            $customerName
//        );

        $loginModel = $this->model->create();
        $data = ['customer_id' => $customerId,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'admin_username' => $adminUsername,
            'secret' => $this->random->getRandomString(64)
        ];
        $loginModel->setData($data);
        $loginModel->save();
        $login->setData($data);


        $store = $this->StoreManager->getStore($customerStoreId);
        $url = $this->Url->setScope($store);


            $redirectUrl = $url->getUrl(
                'loginascustomer/login/index',
                ['secret' => $login->getSecret(),
                    '_nosid' => true]
            );
            $this->getResponse()->setRedirect(
                $redirectUrl
            );
        }
}

