<?php


namespace Web\LoginAsCustomer\Api\Data;

interface LoginAsCustomerSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get LoginAsCustomer list.
     * @return \Web\LoginAsCustomer\Api\Data\LoginAsCustomerInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return mixed
     */
    public function setItems(array $items);
}