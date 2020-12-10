<?php

namespace W4PLEGO\BaseIntegration\Controller\Adminhtml\Integration;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Action
{
    /**
     * @return mixed
     */
    public function execute()
    {
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultForward->forward('edit');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('W4PLEGO_BaseIntegration::processes');
    }
}
