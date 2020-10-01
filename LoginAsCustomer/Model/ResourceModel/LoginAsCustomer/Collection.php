<?php


namespace Web\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'entity_id';
    protected function _construct()
    {
        $this->_init(
            'Web\LoginAsCustomer\Model\LoginAsCustomer',
            'Web\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer'
        );
    }
}
