<?php

namespace W4PLEGO\BaseIntegration\Model;

use Magento\Framework\Model\AbstractModel;
use W4PLEGO\BaseIntegration\Api\Data\SchedulerInterface;
use W4PLEGO\BaseIntegration\Model\ResourceModel\Scheduler as ResourceModelScheduler;

class Scheduler extends AbstractModel implements SchedulerInterface
{
    const START_RUN_TIME        = 'start_run_time';
    const FINISH_RUN_TIME       = 'finish_run_time';
    const SCHEDULE_STATUS       = 'schedule_status';
    const INTEGRATION_ID        = 'integration_id';
    const SCHEDULE_TIME         = 'schedule_time';

    /**
     * Model Scheduler
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModelScheduler::class);
    }

    /**
     * @return mixed|string|null
     */
    public function getIntegrationName()
    {
        return $this->_getData(Integration::INTEGRATION_NAME);
    }

    /**
     * @param string $integrationName
     * @return void
     */
    public function setIntegrationName($integrationName)
    {
        $this->setData(Integration::INTEGRATION_NAME, $integrationName);
    }

    /**
     * @return int|mixed|null
     */
    public function getIntegrationId()
    {
        return $this->_getData(self::INTEGRATION_ID);
    }

    /**
     * @param int $integrationId
     * @return void
     */
    public function setIntegrationId($integrationId)
    {
        $this->setData(self::INTEGRATION_ID, $integrationId);
    }

    /**
     * @return mixed|string|null
     */
    public function getProcessCode()
    {
        return $this->_getData(Integration::PROCESS_CODE);
    }

    /**
     * @param string $processCode
     * @return void
     */
    public function setProcessCode($processCode)
    {
        $this->setData(Integration::PROCESS_CODE, $processCode);
    }

    /**
     * @return mixed|string|null
     */
    public function getScheduleTime()
    {
        return $this->_getData(self::SCHEDULE_TIME);
    }

    /**
     * @param string $scheduleTime
     * @return void
     */
    public function setScheduleTime($scheduleTime)
    {
        $this->setData(self::SCHEDULE_TIME, $scheduleTime);
    }

    /**
     * @return mixed|string|null
     */
    public function getStartRunTime()
    {
        return $this->_getData(self::START_RUN_TIME);
    }

    /**
     * @param string $startRunTime
     * @return void
     */
    public function setStartRunTime($startRunTime)
    {
        $this->setData(self::START_RUN_TIME, $startRunTime);
    }

    /**
     * @return mixed|string|null
     */
    public function getFinishRunTime()
    {
        return $this->_getData(self::FINISH_RUN_TIME);
    }

    /**
     * @param string $finishRunTime
     * @return void
     */
    public function setFinishRunTime($finishRunTime)
    {
        $this->setData(self::FINISH_RUN_TIME, $finishRunTime);
    }

    /**
     * @return string
     */
    public function getScheduleStatus()
    {
        return $this->_getData(self::SCHEDULE_STATUS);
    }

    /**
     * @param string $status
     * @return void
     */
    public function setScheduleStatus($status)
    {
        $this->setData(self::SCHEDULE_STATUS, $status);
    }
}
