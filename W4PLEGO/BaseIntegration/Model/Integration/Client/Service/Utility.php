<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Client\Service;

use Exception;
use Magento\Framework\Serialize\Serializer\Json;
use W4PLEGO\BaseIntegration\Model\Integration\Initiator\Process\RequestBuilderInterface;
use W4PLEGO\BaseIntegration\Model\Logger\Logger;

class Utility
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Json
     */
    protected $json;

    /**
     * Utility constructor.
     * @param Logger $logger
     * @param Json $json
     */
    public function __construct(
        Logger  $logger,
        Json    $json
    ) {
        $this->logger = $logger;
        $this->json = $json;
    }

    /**
     * @param string $response
     * @return mixed
     */
    public function getDecodedHandle(string $response)
    {
        if (!empty($response)) {
            try {
                $response = $this->json->unserialize($response);
            } catch (\Exception $ex) {
                $this->logger->info($ex->getMessage());
            }
        }
        return $response;
    }

    /**
     * @param string $str
     * @return false|string
     */
    public function removeBOM(string $str)
    {
        if (substr($str, 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf)) {
            $str = substr($str, 3);
        }
        return $str;
    }

    /**
     * @param array $requestParams
     * @return array
     * @throws Exception
     */
    public function paramsPreparation(array $requestParams)
    {
        $message = null;

        if (!isset($requestParams[RequestBuilderInterface::CONNECT_TYPE]) &&
            empty($requestParams[RequestBuilderInterface::CONNECT_TYPE])) {
            $message = __('Connect Type is absent.');
            $this->logger->critical($message);
            throw new Exception($message);
        }

        if (!isset($requestParams[RequestBuilderInterface::CONNECT_CONFIG]) &&
            empty($requestParams[RequestBuilderInterface::CONNECT_CONFIG])) {
            $message = __('Connect Config Data is absent.');
            $this->logger->critical($message);
            throw new Exception($message);
        }

        if (!isset($requestParams[RequestBuilderInterface::CONNECT_QUERY]) &&
            empty($requestParams[RequestBuilderInterface::CONNECT_QUERY])) {
            $message = __('Connect Query Params is absent.');
            $this->logger->critical($message);
            throw new Exception($message);
        }

        if (isset($requestParams[RequestBuilderInterface::ENDPOINT_URL]) &&
            empty($requestParams[RequestBuilderInterface::ENDPOINT_URL])) {
            $message = __('Endpoint URL is absent.');
            $this->logger->critical($message);
            throw new Exception($message);
        }

        $config = $requestParams[RequestBuilderInterface::CONNECT_CONFIG];

        if (!isset($config[RequestBuilderInterface::BASE_URI]) &&
            empty($config[RequestBuilderInterface::BASE_URI])) {
            $message = __('Base URL is absent.');
            $this->logger->critical($message);
            throw new Exception($message);
        }

        if (!isset($config[RequestBuilderInterface::CONNECT_AUTH]) &&
            empty($config[RequestBuilderInterface::CONNECT_AUTH])) {
            $message = __('Connection Auth Data is absent.');
            $this->logger->critical($message);
            throw new Exception($message);
        }

        $params = $requestParams[RequestBuilderInterface::CONNECT_QUERY];
        $connectionType = $requestParams[RequestBuilderInterface::CONNECT_TYPE];
        if (!isset($requestParams[RequestBuilderInterface::ENDPOINT_URL])) {
            $endpointUrl = '';
        } else {
            $endpointUrl = $requestParams[RequestBuilderInterface::ENDPOINT_URL];
        }

        return [
            RequestBuilderInterface::CONNECT_TYPE    => $connectionType,
            RequestBuilderInterface::BASE_URI        => $config[RequestBuilderInterface::BASE_URI],
            RequestBuilderInterface::ENDPOINT_URL    => $endpointUrl,
            RequestBuilderInterface::CONNECT_QUERY   => $params,
            RequestBuilderInterface::CONNECT_AUTH    => $config[RequestBuilderInterface::CONNECT_AUTH],
            RequestBuilderInterface::CURL            => $config[RequestBuilderInterface::CURL],
            RequestBuilderInterface::CONNECT_CONFIG  => $config
        ];
    }
}
