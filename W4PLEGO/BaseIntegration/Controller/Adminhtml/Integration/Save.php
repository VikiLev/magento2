<?php

namespace W4PLEGO\BaseIntegration\Controller\Adminhtml\Integration;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use W4PLEGO\BaseIntegration\Cron\Integration as CronIntegration;
use W4PLEGO\BaseIntegration\Model\IntegrationFactory;
use W4PLEGO\BaseIntegration\Model\ResourceModel\IntegrationRepository;

class Save extends Action
{
    /**
     * @var IntegrationRepository
     */
    protected $integrationRepository;

    /**
     * @var IntegrationFactory
     */
    protected $integrationFactory;

    /**
     * @var Session
     */
    protected $adminSession;

    /**
     * @var CronIntegration
     */
    protected $cronIntegration;

    /**
     * @param Action\Context $context
     * @param IntegrationRepository $integrationRepository
     * @param IntegrationFactory $integrationFactory
     * @param Session $adminSession
     * @param CronIntegration $cronIntegration
     */
    public function __construct(
        Action\Context $context,
        IntegrationRepository $integrationRepository,
        IntegrationFactory $integrationFactory,
        Session $adminSession,
        CronIntegration $cronIntegration
    ) {
        parent::__construct($context);
        $this->integrationRepository = $integrationRepository;
        $this->integrationFactory = $integrationFactory;
        $this->adminSession = $adminSession;
        $this->cronIntegration = $cronIntegration;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $integrationId = (int)$this->getRequest()->getParam('id');

            if ($integrationId) {
                $integration = $this->integrationRepository->getById($integrationId);
            } else {
                $integration = $this->integrationFactory->create();
            }

            if (!$integration->getId() && $integrationId) {
                throw new LocalizedException(__('This integration item no longer exists.'));
            }

            $integration->setData($data);

            try {
                $this->integrationRepository->save($integration);
                $this->cronIntegration->createIntegrationSchedule($integration->getData());
                $this->messageManager->addSuccessMessage(__('The data has been saved.'));
                $this->adminSession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath(
                            '*/*/edit',
                            [
                                'id' => $integration->getId(),
                                '_current' => true,
                            ]
                        );
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the data.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
