<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Initiator\Process;

interface RequestBuilderInterface
{
    const CONNECT_AUTH              = 'auth';
    const CONNECT_CONFIG            = 'config';
    const ENDPOINT_URL              = 'endpoint_url';
    const CONNECT_QUERY             = 'query';
    const CONNECT_TIMEOUT           = 'timeout';
    const REQUEST_TIMEOUT           = 'connect_timeout';
    const CURL                      = 'curl';
    const CONNECT_TYPE              = 'connect_type';
    const BASE_URI                  = 'base_uri';
    const USER                      = 'user';
    const PASSWORD                  = 'password';
    const CONNECT_AUTH_TYPE_BASIC   = 'basic';
    const CONNECT_AUTH_TYPE_API     = 'api';
    const CONNECT_AUTH_TYPE         = 'auth_type';
}
