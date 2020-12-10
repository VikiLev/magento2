<?php

namespace W4PLEGO\BaseIntegration\Cron;

use Psr\Log\LoggerInterface as Logger;
use W4PLEGO\BaseIntegration\Model\Integration as ModelIntegration;
use W4PLEGO\BaseIntegration\Model\ResourceModel\SchedulerRepository;
use W4PLEGO\BaseIntegration\Model\Scheduler;
use W4PLEGO\BaseIntegration\Model\SchedulerFactory;

class Integration
{
    /**
     * @var SchedulerRepository
     */
    protected $schedulerRepository;

    /**
     * @var SchedulerFactory
     */
    protected $schedulerFactory;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Updater
     */
    protected $cronUpdater;

    /**
     * Integration constructor.
     * @param SchedulerRepository $schedulerRepository
     * @param SchedulerFactory $schedulerFactory
     * @param Logger $logger
     * @param Updater $cronUpdater
     */
    public function __construct(
        SchedulerRepository $schedulerRepository,
        SchedulerFactory $schedulerFactory,
        Logger $logger,
        Updater $cronUpdater
    ) {
        $this->schedulerRepository = $schedulerRepository;
        $this->schedulerFactory = $schedulerFactory;
        $this->logger = $logger;
        $this->cronUpdater = $cronUpdater;
    }

    /**
     * @param array $integrationData
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function createIntegrationSchedule($integrationData)
    {
        try {
            if (!empty($integrationData)) {
                $scheduleData = $this->readyScheduleData($integrationData);
                $integrationSchedule = $this->schedulerRepository->getByIntegrationId(
                    $integrationData[ModelIntegration::INTEGRATION_ID]
                );

                if (!empty($scheduleData)) {
                    if (!empty($integrationSchedule)) {
                        $integrationSchedule->setIntegrationName($scheduleData[ModelIntegration::INTEGRATION_NAME]);
                        $integrationSchedule->setProcessCode($scheduleData[ModelIntegration::PROCESS_CODE]);
                    } else {
                        $integrationSchedule = $this->schedulerFactory->create();
                        $integrationSchedule->setData($scheduleData);
                    }
                    $this->cronUpdater->getUpdatedSchedule($integrationSchedule);
                    $this->schedulerRepository->save($integrationSchedule);
                } else {
                    if (!empty($integrationSchedule)) {
                        $this->schedulerRepository->delete($integrationSchedule);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @return array
     */
    protected function readyScheduleData(array $data)
    {
        $checkFieldsArr = [
            ModelIntegration::PROCESS_CODE      => ModelIntegration::PROCESS_CODE,
            ModelIntegration::INTEGRATION_NAME  => ModelIntegration::INTEGRATION_NAME,
            Scheduler::INTEGRATION_ID           => ModelIntegration::INTEGRATION_ID,
            ModelIntegration::CRON_ENABLE       => ModelIntegration::CRON_ENABLE
        ];

        foreach ($checkFieldsArr as $key => $value) {
            if (array_key_exists($value, $data) && !empty($data[$value])) {
                $checkFieldsArr[$key] = $data[$value];
            } else {
                return [];
            }
        }
        return $checkFieldsArr;
    }
}
