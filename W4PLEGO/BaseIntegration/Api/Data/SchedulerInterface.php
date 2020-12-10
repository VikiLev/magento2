<?php

namespace W4PLEGO\BaseIntegration\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface SchedulerInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getIntegrationId();

    /**
     * @param int $id
     * @return void
     */
    public function setIntegrationId($id);

    /**
     * @return string
     */
    public function getIntegrationName();

    /**
     * @param string $integrationName
     * @return void
     */
    public function setIntegrationName($integrationName);

    /**
     * @return string
     */
    public function getProcessCode();

    /**
     * @param string $processCode
     * @return void
     */
    public function setProcessCode($processCode);

    /**
     * @return string
     */
    public function getStartRunTime();

    /**
     * @param string $startRunTime
     * @return void
     */
    public function setStartRunTime($startRunTime);

    /**
     * @return string
     */
    public function getFinishRunTime();

    /**
     * @param string $finishRunTime
     * @return void
     */
    public function setFinishRunTime($finishRunTime);

    /**
     * @return string
     */
    public function getScheduleTime();

    /**
     * @param string $scheduleTime
     * @return void
     */
    public function setScheduleTime($scheduleTime);

    /**
     * @return string
     */
    public function getScheduleStatus();

    /**
     * @param string $status
     * @return void
     */
    public function setScheduleStatus($status);
}
