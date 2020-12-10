<?php

namespace W4PLEGO\BaseIntegration\Cron;

use Magento\Config\Model\Config\Backend\Admin\Custom;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;
use Psr\Log\LoggerInterface as Logger;
use W4PLEGO\BaseIntegration\Api\Data\SchedulerInterface;
use W4PLEGO\BaseIntegration\Model\Integration;
use W4PLEGO\BaseIntegration\Model\ResourceModel\IntegrationRepository;
use W4PLEGO\BaseIntegration\Model\ResourceModel\SchedulerRepository;

class Updater
{
    /**
     * @var SchedulerRepository
     */
    protected $schedulerRepository;

    /**
     * @var IntegrationRepository
     */
    protected $integrationRepository;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Updater constructor.
     * @param SchedulerRepository $schedulerRepository
     * @param IntegrationRepository $integrationRepository
     * @param Logger $logger
     * @param StoreManager $storeManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        SchedulerRepository $schedulerRepository,
        IntegrationRepository $integrationRepository,
        Logger $logger,
        StoreManager $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->schedulerRepository = $schedulerRepository;
        $this->integrationRepository = $integrationRepository;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param SchedulerInterface $scheduler
     * @return SchedulerInterface
     * @throws NoSuchEntityException
     */
    public function getUpdatedSchedule(SchedulerInterface $scheduler)
    {
        $date = $this->getCurrentTimeZoneTime();

        try {
            $integration = $this->integrationRepository->getById($scheduler->getIntegrationId());
        } catch (NoSuchEntityException $e) {
            $this->logger->critical($e->getMessage());
        }

        if (empty($integration)) {
            return $scheduler;
        }

        switch ($integration->getFrequency()) {
            case Integration::HALF_HOURLY:
                $date->modify('+30 minutes');
                break;
            case Integration::HOURLY:
                $date->modify('+1 hour');
                break;
            case Integration::DAILY:
                $date->setTime($integration->getScheduleHour(), $integration->getScheduleMin());
                $date->modify('+1 day');
                break;
            case Integration::WEEKLY:
                $date->setTime($integration->getScheduleHour(), $integration->getScheduleMin());
                $date->modify('+1 week');
                break;
            case Integration::MONTHLY:
                $date->setTime($integration->getScheduleHour(), $integration->getScheduleMin());
                $date->modify('+1 month');
                break;
        }
        $scheduleAtTime = $date->format('Y-m-d H:i:s');
        $scheduler->setScheduleTime($scheduleAtTime);

        return $scheduler;
    }

    /**
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getCoreTimezone()
    {
        return $coreTimezone = $this->scopeConfig->getValue(
            Custom::XML_PATH_GENERAL_LOCALE_TIMEZONE,
            ScopeInterface::SCOPE_WEBSITE,
            $this->storeManager->getStore(Store::DEFAULT_STORE_ID)->getId()
        );
    }

    /**
     * @return \DateTime
     * @throws NoSuchEntityException
     */
    public function getCurrentTimeZoneTime()
    {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone($this->getCoreTimezone()));
        return $date;
    }
}
