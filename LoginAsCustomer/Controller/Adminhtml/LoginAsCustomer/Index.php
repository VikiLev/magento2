<?php


namespace Web\LoginAsCustomer\Controller\Adminhtml\LoginAsCustomer;

class Index extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->setActiveMenu('Magento_Customer::customer');
            $resultPage->getConfig()->getTitle()->prepend(__("Login As Customer"));
            return $resultPage;
        }

}

