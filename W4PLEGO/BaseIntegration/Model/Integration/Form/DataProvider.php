<?php

namespace W4PLEGO\BaseIntegration\Model\Integration\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use W4PLEGO\BaseIntegration\Model\ResourceModel\Integration\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $integrationCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $integrationCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $integrationCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $this->loadedData = [];

        foreach ($items as $integration) {
            $this->loadedData[$integration->getId()] = $integration->getData();
        }
        return $this->loadedData;
    }
}
