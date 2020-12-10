<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Initiator\Process;

interface ResponseHandlerInterface
{
    /**
     * @param array $response
     * @return mixed
     */
    public function getHandle(array $response);
}
