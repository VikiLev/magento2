<?php


namespace Web\LoginAsCustomer\Controller\Login;


class Index extends \Magento\Framework\App\Action\Action
{

    public $LoginAsCustomer;
    public $authorization;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Web\LoginAsCustomer\Model\LoginAsCustomer $LoginAsCustomer

    ) {
        $this->LoginAsCustomer = $LoginAsCustomer;
        $this->authorization = $context->getAuthorization();

        parent::__construct($context);
    }

    public function execute()
    {
//        $canModify = $this->authorization->isAllowed('Web_LoginAsCustomer::web_login_as_customer');
//        if ($canModify)
        {
            $login = $this->checkLogin();
            if (!$login) {
                $this->_redirect('customer/account/login');
                return;
            }
            try {

                $login->authenticateCustomer();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_redirect('customer/account/login');
                return;
            }
            $this->messageManager->addSuccessMessage(
                __('You are logged in as customer: %1', $login->getCustomer()->getName())
            );
            $this->_redirect('customer/account');
        }
    }


    public function checkLogin()
    {
        $secret = $this->getRequest()->getParam('secret');
        if (!$secret) {
            $this->messageManager->addErrorMessage(__('Cannot login to account. No secret key provided.'));
            return false;
        }
        $login = $this->LoginAsCustomer->loadNotUsed($secret);
        if ($login->getId()) {
                 return $login;
        }
        else {
            $this->messageManager->addErrorMessage(__('Cannot login to account. Secret key is not valid.'));
            return false;
        }
    }
}
