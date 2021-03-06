<?php


namespace Web\LoginAsCustomer\Model;


use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Web\LoginAsCustomer\Api\LoginAsCustomerRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Web\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer as ResourceLoginAsCustomer;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SortOrder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use Web\LoginAsCustomer\Api\Data\LoginAsCustomerInterfaceFactory;
use Web\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer\CollectionFactory as LoginAsCustomerCollectionFactory;
use Web\LoginAsCustomer\Api\Data\LoginAsCustomerSearchResultsInterfaceFactory;

class LoginAsCustomerRepository
{

    protected $dataObjectProcessor;
    protected $dataObjectHelper;
    protected $loginAsCustomerCollectionFactory;
    protected $dataLoginAsCustomerFactory;
    protected $searchResultsFactory;
    protected $loginAsCustomerFactory;
    protected $resource;
    private $storeManager;


    public function __construct(
        ResourceLoginAsCustomer $resource,
        loginAsCustomerFactory $loginAsCustomerFactory,
        LoginAsCustomerInterfaceFactory $dataLoginAsCustomerFactory,
        LoginAsCustomerCollectionFactory $loginAsCustomerCollectionFactory,
        LoginAsCustomerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->loginAsCustomerFactory = $loginAsCustomerFactory;
        $this->loginAsCustomerCollectionFactory = $loginAsCustomerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataLoginAsCustomerFactory = $dataLoginAsCustomerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }
    /**
     * {@inheritdoc}
     */
    public function save(
        \Web\LoginAsCustomer\Api\Data\LoginAsCustomerInterface $loginAsCustomer
    ) {
        try {
            $loginAsCustomer->getResource()->save($loginAsCustomer);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the loginAsCustomer: %1',
                $exception->getMessage()
            ));
        }
        return $loginAsCustomer;
    }



    public function getById($loginAsCustomerId)
    {
        $loginAsCustomer = $this->loginAsCustomerFactory->create();
        $loginAsCustomer->getResource()->load($loginAsCustomer, $loginAsCustomerId);
        if (!$loginAsCustomer->getId()) {
            throw new NoSuchEntityException(__('loginAsCustomer with id "%1" does not exist.', $loginAsCustomerId));
        }
        return $loginAsCustomer;
    }


    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->LoginAsCustomerCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }


    public function delete(
        \Web\LoginAsCustomer\Api\Data\LoginAsCustomerInterface $loginAsCustomer
    ) {
        try {
            $loginAsCustomer->getResource()->delete($loginAsCustomer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the loginAsCustomer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($loginAsCustomerId)
    {
        return $this->delete($this->getById($loginAsCustomerId));
    }
}
