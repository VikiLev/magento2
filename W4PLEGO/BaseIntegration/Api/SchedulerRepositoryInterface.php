<?php

namespace W4PLEGO\BaseIntegration\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use W4PLEGO\BaseIntegration\Api\Data\SchedulerInterface;

interface SchedulerRepositoryInterface
{
    /**
     * @param int $id
     * @return SchedulerInterface
     * @throws NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param int $integrationId
     * @return mixed
     */
    public function getByIntegrationId($integrationId);

    /**
     * @param SchedulerInterface $scheduler
     * @return SchedulerInterface
     */
    public function save(SchedulerInterface $scheduler);

    /**
     * @param SchedulerInterface $scheduler
     * @return SchedulerInterface
     */
    public function delete(SchedulerInterface $scheduler);
}
