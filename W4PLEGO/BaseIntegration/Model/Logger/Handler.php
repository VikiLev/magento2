<?php

namespace W4PLEGO\BaseIntegration\Model\Logger;

use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Monolog\Logger;

class Handler extends Base
{
    /**
     * @var int $loggerType
     */
    protected $loggerType = Logger::INFO;

    /**
     * @var string $fileName
     */
    public $fileName;

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * Handler constructor.
     * @param DriverInterface $filesystem
     * @param TimezoneInterface $timezone
     * @param null $filePath
     * @throws \Exception
     */
    public function __construct(
        DriverInterface $filesystem,
        TimezoneInterface $timezone,
        $filePath = null
    ) {
        $this->timezone = $timezone;
        $this->initFileName();

        parent::__construct($filesystem, $filePath, $this->fileName);
    }

    /**
     * @return string
     */
    protected function getTimeStamp()
    {
        return $this->timezone->formatDateTime(
            $this->timezone->date(),
            null,
            null,
            null,
            $this->timezone->getConfigTimezone(),
            'yyyy-MM-dd'
        );
    }

    /**
     * @return string
     */
    protected function getLogIdentifier()
    {
        return $this->timezone->formatDateTime(
            $this->timezone->date(),
            null,
            null,
            null,
            $this->timezone->getConfigTimezone(),
            'HH-mm-ss'
        );
    }

    /**
     * @param null $processCode
     * @return $this
     */
    public function initFileName($processCode = null)
    {
        $this->fileName = '/var/log/web4pro_integrations_logs/' .
            $processCode . DIRECTORY_SEPARATOR . $this->getTimeStamp() . DIRECTORY_SEPARATOR .
            $this->getLogIdentifier() . '.log';

        return $this;
    }
}
