<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Client;

use W4PLEGO\BaseIntegration\Api\Data\ConnectorInterface;
use W4PLEGO\BaseIntegration\Model\Logger\Logger;

class Connector
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * @var CurlService
     */
    protected $curl;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Connector constructor.
     * @param Service $service
     * @param CurlService $curl
     * @param Logger $logger
     */
    public function __construct(
        Service $service,
        CurlService $curl,
        Logger $logger
    ) {
        $this->service = $service;
        $this->curl = $curl;
        $this->logger = $logger;
    }

    /**
     * @param array $params
     * @param string $connectorType
     * @return array
     * @throws \Exception
     */
    public function requestDataExecutor($params, $connectorType)
    {
        $this->logger->info(__('Connector Type: "%1"', $connectorType));
        if ($connectorType === ConnectorInterface::GUZZLE) {
            return $this->service->requestExecute($params);
        }

        return $this->curl->requestExecute($params);
    }
}
