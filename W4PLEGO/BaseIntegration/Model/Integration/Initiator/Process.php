<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Initiator;

use Magento\Framework\DataObjectFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\ObjectManagerInterface;
use W4PLEGO\BaseIntegration\Model\Integration;
use W4PLEGO\BaseIntegration\Model\ResourceModel\IntegrationRepository;

class Process
{
    /**
     * @var IntegrationRepository
     */
    protected $integrationRepository;

    /**
     * Object Manager
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * DataObject
     *
     * @var DataObjectFactory
     */
    protected $paramsObject;

    /**
     * @var $processCode
     */
    protected $processCode;

    /**
     * @var $processedIntegration
     */
    protected $processedIntegration;

    /**
     * Process constructor.
     * @param IntegrationRepository $integrationRepository
     * @param ObjectManagerInterface $objectManager
     * @param DataObjectFactory $dataObjectFactory
     */
    public function __construct(
        IntegrationRepository $integrationRepository,
        ObjectManagerInterface $objectManager,
        DataObjectFactory $dataObjectFactory
    ) {
        $this->integrationRepository = $integrationRepository;
        $this->objectManager = $objectManager;
        $this->paramsObject = $dataObjectFactory->create();
    }

    /**
     * @param int $integrationId
     * @param array $params
     * @return mixed
     * @throws NoSuchEntityException
     * @throws AlreadyExistsException
     */
    public function getProcess(int $integrationId, $params = [])
    {
        $processor = null;

        if ($integrationId) {
            $processedIntegration = $this->integrationRepository->getById($integrationId);

            if (!empty($processedIntegration)) {
                $this->processedIntegration = $processedIntegration;
                $processClass = $processedIntegration->getProcessClass();
                $this->processCode = $processedIntegration->getProcessCode();
                $processedIntegration->setStatus(Integration::STATUS_PROCESSING);
                $this->integrationRepository->save($processedIntegration);

                $baseParams = ['object_manager' => $this->objectManager];
                $initParams = array_merge($params, $baseParams);

                $this->paramsObject->setData($initParams);

                $processor = $this->objectManager->create(
                    $processClass,
                    ['initParams' => $this->paramsObject, 'processedIntegration' => $this]
                );

                return $processor;
            }
        }
        return false;
    }

    /**
     * @return bool
     * @throws AlreadyExistsException
     */
    public function stopProcess()
    {
        if (!empty($this->processedIntegration)) {
            $this->processedIntegration->setStatus(Integration::STATUS_PENDING);
            $this->integrationRepository->save($this->processedIntegration);
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws AlreadyExistsException
     */
    public function errorProcess()
    {
        if (!empty($this->processedIntegration)) {
            $this->processedIntegration->setStatus(Integration::STATUS_ERROR);
            $this->integrationRepository->save($this->processedIntegration);
            return true;
        }
        return false;
    }
}
