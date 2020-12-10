<?php

namespace W4PLEGO\BaseIntegration\Controller\Adminhtml\Integration;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Layout;

class Edit extends Action
{
    /**
     * @return ResultInterface|Layout
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Integration'));
        return $resultPage;
    }
}
