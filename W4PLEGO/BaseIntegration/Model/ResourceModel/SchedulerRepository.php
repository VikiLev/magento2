<?php

namespace W4PLEGO\BaseIntegration\Model\ResourceModel;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use W4PLEGO\BaseIntegration\Api\Data\SchedulerInterface;
use W4PLEGO\BaseIntegration\Api\SchedulerRepositoryInterface;
use W4PLEGO\BaseIntegration\Model\ResourceModel\Scheduler as ResourceScheduler;
use W4PLEGO\BaseIntegration\Model\SchedulerFactory;

class SchedulerRepository implements SchedulerRepositoryInterface
{
    /**
     * @var SchedulerFactory
     */
    protected $schedulerFactory;

    /**
     * @var ResourceScheduler
     */
    protected $resource;

    /**
     * SchedulerRepository constructor.
     * @param SchedulerFactory $schedulerFactory
     * @param ResourceScheduler $schedulerResource
     */
    public function __construct(
        SchedulerFactory $schedulerFactory,
        ResourceScheduler $schedulerResource
    ) {
        $this->schedulerFactory = $schedulerFactory;
        $this->resource = $schedulerResource;
    }

    /**
     * @param int $id
     * @return \W4PLEGO\BaseIntegration\Model\Scheduler
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $scheduler = $this->schedulerFactory->create();
        $this->resource->load($scheduler, $id);
        if (!$scheduler->getId()) {
            throw new NoSuchEntityException(__('Unable to find schedule with ID "%1"', $id));
        }
        return $scheduler;
    }

    /**
     * @param int $integrationId
     * @return bool|mixed|\W4PLEGO\BaseIntegration\Model\Scheduler
     * @throws NoSuchEntityException
     */
    public function getByIntegrationId($integrationId)
    {
        $schedulerId = $this->resource->getScheduleIdByIntegrationId($integrationId);
        if (empty($schedulerId)) {
            return false;
        }
        return $this->getById($schedulerId);
    }

    /**
     * @param SchedulerInterface $scheduler
     * @return SchedulerInterface
     * @throws AlreadyExistsException
     */
    public function save(SchedulerInterface $scheduler)
    {
        $this->resource->save($scheduler);
        return $scheduler;
    }

    /**
     * @param SchedulerInterface $scheduler
     * @return SchedulerInterface
     * @throws \Exception
     */
    public function delete(SchedulerInterface $scheduler)
    {
        $this->resource->delete($scheduler);
        return $scheduler;
    }
}
