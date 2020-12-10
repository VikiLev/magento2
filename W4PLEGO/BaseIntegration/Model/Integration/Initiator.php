<?php

namespace W4PLEGO\BaseIntegration\Model\Integration;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use W4PLEGO\BaseIntegration\Model\Integration\Initiator\ProcessFactory;
use W4PLEGO\BaseIntegration\Model\Logger\Logger;

class Initiator
{
    const INITIATOR         = 'initiator';
    const INITIATOR_CRON    = 'CRON';
    const INITIATOR_ADMIN   = 'ADMIN';

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var ProcessFactory
     */
    protected $processFactory;

    /**
     * Initiator constructor.
     * @param Logger $logger
     * @param ProcessFactory $processFactory
     */
    public function __construct(
        Logger $logger,
        ProcessFactory $processFactory
    ) {
        $this->logger = $logger;
        $this->processFactory = $processFactory;
    }

    /**
     * @param int $integrationId
     * @param array $params
     * @return bool|mixed
     * @throws NoSuchEntityException
     * @throws AlreadyExistsException
     */
    public function initRun(int $integrationId, array $params)
    {
        $this->logger->info('Start Init Process');
        $processor = $this->processFactory->create();
        $startedIntegration = $processor->getProcess($integrationId, $params);
        $startedIntegration->runIntegration();
        $processor->stopProcess();
        $this->logger->info(__('--===Process Finish===--'));

        return $startedIntegration;
    }
}
