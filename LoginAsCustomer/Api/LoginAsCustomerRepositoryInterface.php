<?php


namespace Web\LoginAsCustomer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LoginAsCustomerRepositoryInterface
{

    public function save(
        \Web\LoginAsCustomer\Api\Data\LoginAsCustomerInterface $loginAsCustomerId
    );
    public function getById($loginAsCustomerId);

    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    public function delete(
        \Web\LoginAsCustomer\Api\Data\LoginAsCustomerInterface $loginAsCustomerId
    );

    public function deleteById($loginAsCustomerId);
}
