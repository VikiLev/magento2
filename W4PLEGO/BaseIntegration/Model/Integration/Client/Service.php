<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Client;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use W4PLEGO\BaseIntegration\Model\Integration\Client\Service\Utility;
use W4PLEGO\BaseIntegration\Model\Integration\Initiator\Process\RequestBuilderInterface;
use W4PLEGO\BaseIntegration\Model\Logger\Logger;

class Service
{
    /**
     * @var ResponseFactory
     */
    protected $responseFactory;

    /**
     * @var ClientFactory
     */
    protected $clientFactory;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Utility
     */
    protected $utility;

    /**
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param Logger $logger
     * @param Utility $utility
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Logger $logger,
        Utility $utility
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->logger = $logger;
        $this->utility = $utility;
    }

    /**
     * @param array $requestParams
     * @return array
     * @throws Exception
     */
    public function requestExecute(array $requestParams): array
    {
        $responseContent = [];

        if (!empty($requestParams)) {
            $preparedParams = $this->utility->paramsPreparation($requestParams);

            $config = [];
            $connectAuthType = $preparedParams[RequestBuilderInterface::CONNECT_AUTH]
                                        [RequestBuilderInterface::CONNECT_AUTH_TYPE];

            if ($connectAuthType == RequestBuilderInterface::CONNECT_AUTH_TYPE_BASIC) {
                $preparedParams[RequestBuilderInterface::CONNECT_CONFIG][RequestBuilderInterface::CONNECT_AUTH] = [
                    $preparedParams[RequestBuilderInterface::CONNECT_AUTH][RequestBuilderInterface::USER],
                    $preparedParams[RequestBuilderInterface::CONNECT_AUTH][RequestBuilderInterface::PASSWORD],
                    $preparedParams[RequestBuilderInterface::CONNECT_AUTH][RequestBuilderInterface::CONNECT_AUTH_TYPE]
                ];

                $config = $preparedParams[RequestBuilderInterface::CONNECT_CONFIG];
            }

            $params = $preparedParams[RequestBuilderInterface::CONNECT_QUERY];
            $connectionType = $preparedParams[RequestBuilderInterface::CONNECT_TYPE];
            $endpointUrl = $preparedParams[RequestBuilderInterface::ENDPOINT_URL];
            if (empty($endpointUrl)) {
                $endpointUrl = $preparedParams[RequestBuilderInterface::BASE_URI];
            }

            $response = $this->doRequest($endpointUrl, $config, $params, $connectionType);
            $status = $response->getStatusCode();

            if ($status !== 200 && $status !== 201) {
                $message = $response->getReasonPhrase();
                $this->logger->critical($message);
                throw new Exception($message);
            }
            $responseBody = $response->getBody();
            $responseContent = $responseBody->getContents();
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
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array $config
     * @param array $params
     * @param string $requestMethod
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array $config = [],
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        if ($requestMethod == Request::HTTP_METHOD_POST) {
            $paramsJson = json_encode($params);
            $config['headers'] = ['Content-Type' => 'application/json'];
            $config['headers'] = ['Content-Length' => strlen($paramsJson)];
            $params['body'] = $paramsJson;
        }

        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => $config]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}
