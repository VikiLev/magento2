<?php

namespace W4PLEGO\BaseIntegration\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface IntegrationInterface extends ExtensibleDataInterface
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
    public function getProcessClass();

    /**
     * @param string $processClass
     * @return void
     */
    public function setProcessClass($processClass);

    /**
     * @return string
     */
    public function getFrequency();

    /**
     * @param string $frequency
     * @return void
     */
    public function setFrequency($frequency);

    /**
     * @return string
     */
    public function getScheduleHour();

    /**
     * @param string $hour
     * @return void
     */
    public function setScheduleHour($hour);

    /**
     * @return string
     */
    public function getScheduleMin();

    /**
     * @param string $min
     * @return void
     */
    public function setScheduleMin($min);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     * @return void
     */
    public function setStatus($status);
}
