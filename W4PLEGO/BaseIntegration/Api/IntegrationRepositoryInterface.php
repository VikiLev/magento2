<?php

namespace W4PLEGO\BaseIntegration\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use W4PLEGO\BaseIntegration\Api\Data\IntegrationInterface;

interface IntegrationRepositoryInterface
{
    /**
     * @param int $id
     * @return IntegrationInterface
     * @throws NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param IntegrationInterface $integration
     * @return IntegrationInterface
     */
    public function save(IntegrationInterface $integration);
}
