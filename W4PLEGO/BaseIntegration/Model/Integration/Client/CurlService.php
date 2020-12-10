<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Client;

use Exception;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Webapi\Rest\Request;
use W4PLEGO\BaseIntegration\Model\Integration\Client\Service\Utility;
use W4PLEGO\BaseIntegration\Model\Integration\Initiator\Process\RequestBuilderInterface;
use W4PLEGO\BaseIntegration\Model\Logger\Logger;

class CurlService extends Curl
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Utility
     */
    protected $utility;

    /**
     * @var string $responseCodeStatus
     */
    protected $responseCodeStatus;

    /**
     * CurlService constructor.
     * @param Logger $logger
     * @param Utility $utility
     */
    public function __construct(
        Logger $logger,
        Utility $utility
    ) {
        $this->logger = $logger;
        $this->utility = $utility;
    }

    /**
     * @param array $requestParams
     * @return array
     * @throws Exception
     */
    public function requestExecute(array $requestParams) : array
    {
        $responseContent = [];

        if (!empty($requestParams)) {
            $this->reset();
            $preparedParams = $this->utility->paramsPreparation($requestParams);

            $config = $requestParams[RequestBuilderInterface::CONNECT_CONFIG];
            $params = $preparedParams[RequestBuilderInterface::CONNECT_QUERY];
            $connectionType = $preparedParams[RequestBuilderInterface::CONNECT_TYPE];
            $endpointUrlFull = $preparedParams[RequestBuilderInterface::BASE_URI] .
                $preparedParams[RequestBuilderInterface::ENDPOINT_URL];

            $connectAuthType = $preparedParams[RequestBuilderInterface::CONNECT_AUTH]
                                        [RequestBuilderInterface::CONNECT_AUTH_TYPE];

            if ($connectAuthType == RequestBuilderInterface::CONNECT_AUTH_TYPE_BASIC) {
                $this->setCredentials(
                    $preparedParams[RequestBuilderInterface::CONNECT_AUTH][RequestBuilderInterface::USER],
                    $preparedParams[RequestBuilderInterface::CONNECT_AUTH][RequestBuilderInterface::PASSWORD]
                );
            }

            $this->setOptions($config[RequestBuilderInterface::CURL]);

            switch ($connectionType) {
                case Request::HTTP_METHOD_POST:
                    $params = json_encode($params);
                    $this->addHeader('Content-Type', 'application/json');
                    $this->addHeader('Content-Length', strlen($params));
                    $this->logger->info(__('Send POST Request: "%1"', $endpointUrlFull));
                    $this->post($endpointUrlFull, $params);
                    break;
                case Request::HTTP_METHOD_GET:
                    $uri = $this->prepareGet($endpointUrlFull, $params);
                    $this->logger->info(__('Send GET Request: "%1"', $uri));
                    $this->get($uri);
                    break;
                default:
                    $this->logger->critical(__('Request Method Is Empty.'));
                    return [];
            }

            $responseContent = $this->getBody();
            $status = $this->getStatus();

            if ($status !== $this->responseCodeStatus) {
                $status = $this->responseCodeStatus;
            }

            $this->logger->info(__('Response is: "%1"', $responseContent));

            if ($status !== 200 && $status !== 201) {
                $message = __('Response Status is "%1"', $status);
                $this->logger->critical($message);
                throw new Exception($message);
            }

            $this->logger->info(__('Response Status is: "%1"', $status));

            if (!empty($responseContent)) {
                $responseContent = $this->utility->removeBOM($responseContent);
                $responseContent = $this->utility->getDecodedHandle($responseContent);

                if (is_string($responseContent)) {
                    $message = __('Response is not decoded.');
                    $this->logger->critical($message);
                    throw new Exception($message);
                }
            }
        } else {
            $this->logger->critical(__('Empty Request Params'));
        }

        return $responseContent;
    }

    /**
     * @param string $uri
     * @param array $params
     * @return string
     */
    protected function prepareGet($uri, array $params = [])
    {
        if ($params) {
            $uri .= ((parse_url($uri, PHP_URL_QUERY)) ? "&" : "?") . \preg_replace(
                '/%5B([0-9]+)?%5D=/',
                '[]=',
                \http_build_query($params)
            );
        }

        return $uri;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $params
     * @throws Exception
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function makeRequest($method, $uri, $params = [])
    {
        $this->_ch = curl_init();

        $this->curlOption(CURLOPT_URL, $uri);
        if ($method === 'POST') {
            $this->curlOption(CURLOPT_POST, 1);
            $this->curlOption(CURLOPT_POSTFIELDS, is_array($params) ? http_build_query($params) : $params);
        } elseif ($method === 'GET') {
            $this->curlOption(CURLOPT_HTTPGET, 1);
        } else {
            $this->curlOption(CURLOPT_CUSTOMREQUEST, $method);
        }

        if (!empty($this->_headers)) {
            $heads = [];
            foreach ($this->_headers as $k => $v) {
                $heads[] = $k . ': ' . $v;
            }
            $this->curlOption(CURLOPT_HTTPHEADER, $heads);
        }

        if (!empty($this->_cookies)) {
            $cookies = [];
            foreach ($this->_cookies as $k => $v) {
                $cookies[] = "{$k}={$v}";
            }
            $this->curlOption(CURLOPT_COOKIE, implode(";", $cookies));
        }

        if ($this->_timeout) {
            $this->curlOption(CURLOPT_TIMEOUT, $this->_timeout);
        }

        if ($this->_port != 80) {
            $this->curlOption(CURLOPT_PORT, $this->_port);
        }

        $this->curlOption(CURLOPT_RETURNTRANSFER, 1);
        $this->curlOption(CURLOPT_HEADERFUNCTION, [$this, 'parseHeaders']);

        if (!empty($this->_curlUserOptions)) {
            foreach ($this->_curlUserOptions as $k => $v) {
                $this->curlOption($k, $v);
            }
        }

        $this->_headerCount = 0;
        $this->_responseHeaders = [];
        $this->_responseBody = curl_exec($this->_ch);
        $this->responseCodeStatus = curl_getinfo($this->_ch, CURLINFO_HTTP_CODE);
        $err = curl_errno($this->_ch);
        if ($err) {
            $this->doError(curl_error($this->_ch));
        }

        curl_close($this->_ch);
    }

    /**
     * Reset class to initial values
     * @return $this
     */
    public function reset()
    {
        $this->_host = 'localhost';
        $this->_port = 80;
        $this->_sock = null;
        $this->_headers = [];
        $this->_postFields = [];
        $this->_cookies = [];
        $this->_responseHeaders = [];
        $this->_responseBody = '';
        $this->_responseStatus = 0;
        $this->_timeout = 300;
        $this->_redirectCount = 0;
        $this->_ch = null;
        $this->_curlUserOptions = [];
        $this->_headerCount = 0;
        $this->responseCodeStatus = 0;
        return $this;
    }
}
