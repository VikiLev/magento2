<?php

namespace W4PLEGO\BaseIntegration\Controller\Adminhtml\Integration;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use W4PLEGO\BaseIntegration\Model\Integration\InitiatorFactory;
use W4PLEGO\BaseIntegration\Model\Integration\Initiator;

class Run extends Action
{
    /**
     * @var InitiatorFactory
     */
    protected $initiatorFactory;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @param Action\Context $context
     * @param InitiatorFactory $initiatorFactory
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        Action\Context $context,
        InitiatorFactory $initiatorFactory,
        ResultFactory $resultFactory
    ) {
        $this->initiatorFactory = $initiatorFactory;
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $integrationId = (int)$this->getRequest()->getParam('id');
        $params = [];
        $params[Initiator::INITIATOR] = Initiator::INITIATOR_ADMIN;

        if ($integrationId) {
            try {
                $initiator = $this->initiatorFactory->create()->initRun($integrationId, $params);
                $resultData = $initiator->getFlagProcessData();
            } catch (\Exception $e) {
                $resultData[] = $e->getMessage();
            }
        } else {
            $errMsg = __('Expected Integration ID');
            $resultData[] = $errMsg;
        }
        $resultJson->setData($resultData);
        return $resultJson;
    }

    /**
     * Check the permission to run it
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}
