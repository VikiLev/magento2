<?php

namespace W4PLEGO\BaseIntegration\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use W4PLEGO\BaseIntegration\Api\Data\IntegrationInterface;
use W4PLEGO\BaseIntegration\Model\ResourceModel\Integration as ResourceModelIntegration;

class Integration extends AbstractExtensibleModel implements IntegrationInterface
{
    const STATUS_PENDING        = 'Pending';
    const STATUS_PROCESSING     = 'Processing';
    const STATUS_ERROR          = 'Error';
    const STATUS_DISABLED       = 'Disabled';
    const INTEGRATION_NAME      = 'integration_name';
    const INTEGRATION_ID        = 'id';
    const PROCESS_CODE          = 'process_code';
    const PROCESS_CLASS         = 'process_class';
    const CRON_ENABLE           = 'cron_enable';
    const STATUS                = 'status';
    const HOUR                  = 'schedule_hour';
    const MINUTE                = 'schedule_min';
    const FREQUENCY             = 'frequency';
    const HALF_HOURLY           = 'halfhourly';
    const HOURLY                = 'hourly';
    const DAILY                 = 'daily';
    const WEEKLY                = 'weekly';
    const MONTHLY               = 'monthly';

    /**
     * Model Initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModelIntegration::class);
    }

    /**
     * @return string[]
     */
    public function getAvailableStatuses()
    {
        return ['1' => 'Enable', '0' => 'Disable'];
    }

    /**
     * @return mixed|string|null
     */
    public function getIntegrationName()
    {
        return $this->_getData(self::INTEGRATION_NAME);
    }

    /**
     * @param string $integrationName
     * @return void
     */
    public function setIntegrationName($integrationName)
    {
        $this->setData(self::INTEGRATION_NAME, $integrationName);
    }

    /**
     * @return mixed|string|null
     */
    public function getProcessClass()
    {
        return $this->_getData(self::PROCESS_CLASS);
    }

    /**
     * @param string $processClass
     * @return void
     */
    public function setProcessClass($processClass)
    {
        $this->setData(self::PROCESS_CLASS, $processClass);
    }

    /**
     * @return mixed|string|null
     */
    public function getProcessCode()
    {
        return $this->_getData(self::PROCESS_CODE);
    }

    /**
     * @param string $processCode
     * @return void
     */
    public function setProcessCode($processCode)
    {
        $this->setData(self::PROCESS_CODE, $processCode);
    }

    /**
     * @return mixed|string|null
     */
    public function getFrequency()
    {
        return $this->_getData(self::FREQUENCY);
    }

    /**
     * @param string $frequency
     * @return void
     */
    public function setFrequency($frequency)
    {
        $this->setData(self::FREQUENCY, $frequency);
    }

    /**
     * @return mixed|string|null
     */
    public function getScheduleHour()
    {
        return $this->_getData(self::HOUR);
    }

    /**
     * @param string $hour
     * @return void
     */
    public function setScheduleHour($hour)
    {
        $this->setData(self::HOUR, $hour);
    }

    /**
     * @return mixed|string|null
     */
    public function getScheduleMin()
    {
        return $this->_getData(self::MINUTE);
    }

    /**
     * @param string $minute
     * @return void
     */
    public function setScheduleMin($minute)
    {
        $this->setData(self::MINUTE, $minute);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @param string $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
    }
}
