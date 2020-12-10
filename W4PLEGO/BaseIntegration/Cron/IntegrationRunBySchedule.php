<?php

namespace W4PLEGO\BaseIntegration\Cron;

use Magento\Framework\Exception\AlreadyExistsException;
use W4PLEGO\BaseIntegration\Api\Data\SchedulerInterface;
use W4PLEGO\BaseIntegration\Model\Integration\InitiatorFactory;
use W4PLEGO\BaseIntegration\Model\Integration\Initiator;
use W4PLEGO\BaseIntegration\Model\ResourceModel\SchedulerRepository;
use W4PLEGO\BaseIntegration\Model\SchedulerFactory;

class IntegrationRunBySchedule
{
    /**
     * @var InitiatorFactory
     */
    protected $initiatorFactory;

    /**
     * @var SchedulerFactory
     */
    protected $schedulerFactory;

    /**
     * @var Updater
     */
    protected $cronUpdater;

    /**
     * @var SchedulerRepository
     */
    protected $schedulerRepository;

    /**
     * IntegrationRunBySchedule constructor.
     * @param InitiatorFactory $initiatorFactory
     * @param SchedulerFactory $schedulerFactory
     * @param Updater $cronUpdater
     * @param SchedulerRepository $schedulerRepository
     */
    public function __construct(
        InitiatorFactory $initiatorFactory,
        SchedulerFactory $schedulerFactory,
        Updater $cronUpdater,
        SchedulerRepository $schedulerRepository
    ) {
        $this->initiatorFactory = $initiatorFactory;
        $this->schedulerFactory = $schedulerFactory;
        $this->cronUpdater = $cronUpdater;
        $this->schedulerRepository = $schedulerRepository;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $params = [];
        $params[Initiator::INITIATOR] = Initiator::INITIATOR_CRON;
        try {
            $collection = $this->schedulerFactory->create()->getCollection();
            if (!empty($collection) && $collection->getSize()) {
                foreach ($collection as $integrationSchedule) {
                    $startRunTime = $this->cronUpdater->getCurrentTimeZoneTime()->format('Y-m-d H:i:s');
                    if ($startRunTime >= $integrationSchedule->getScheduleTime()) {
                        $integrationSchedule->setStartRunTime($startRunTime);
                        $initiator = $this->initiatorFactory->create()
                        ->initRun($integrationSchedule->getIntegrationId(), $params);

                        $resultData = $initiator->getFlagProcessData();
                        $integrationSchedule = $this->cronUpdater->getUpdatedSchedule($integrationSchedule);
                        $finishRunTime = $this->cronUpdater->getCurrentTimeZoneTime()->format('Y-m-d H:i:s');
                        $integrationSchedule->setFinishRunTime($finishRunTime);
                        $this->saveNewSchedule($integrationSchedule);
                    }
                }
            }
        } catch (\Exception $e) {
            $resultData[] = $e->getMessage();
        }
    }

    /**
     * @param SchedulerInterface $scheduler
     * @throws AlreadyExistsException
     * @return void
     */
    protected function saveNewSchedule(SchedulerInterface $scheduler)
    {
        $this->schedulerRepository->save($scheduler);
    }
}
