<?php

namespace W4PLEGO\BaseIntegration\Model\ResourceModel;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use W4PLEGO\BaseIntegration\Api\Data\IntegrationInterface;
use W4PLEGO\BaseIntegration\Api\IntegrationRepositoryInterface;
use W4PLEGO\BaseIntegration\Model\ResourceModel\Integration as ResourceIntegration;
use W4PLEGO\BaseIntegration\Model\IntegrationFactory;

class IntegrationRepository implements IntegrationRepositoryInterface
{
    /**
     * @var IntegrationFactory
     */
    protected $integrationFactory;

    /**
     * @var ResourceIntegration
     */
    protected $resource;

    /**
     * IntegrationRepository constructor.
     * @param IntegrationFactory $integrationFactory
     * @param ResourceIntegration $integrationResource
     */
    public function __construct(
        IntegrationFactory $integrationFactory,
        ResourceIntegration $integrationResource
    ) {
        $this->integrationFactory = $integrationFactory;
        $this->resource = $integrationResource;
    }

    /**
     * @param int $id
     * @return IntegrationInterface|\W4PLEGO\BaseIntegration\Model\Integration
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $integration = $this->integrationFactory->create();
        $this->resource->load($integration, $id);
        if (!$integration->getId()) {
            throw new NoSuchEntityException(__('Unable to find integration with ID "%1"', $id));
        }
        return $integration;
    }

    /**
     * @param IntegrationInterface $integration
     * @return IntegrationInterface
     * @throws AlreadyExistsException
     */
    public function save(IntegrationInterface $integration)
    {
        $this->resource->save($integration);
        return $integration;
    }
}
