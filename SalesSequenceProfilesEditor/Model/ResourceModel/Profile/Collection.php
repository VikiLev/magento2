<?php

namespace W4PLEGO\SalesSequenceProfilesEditor\Model\ResourceModel\Profile;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'profile_id';

    protected function _construct()
    {
        $this->_init(
            'Magento\SalesSequence\Model\Profile',
            'Magento\SalesSequence\Model\ResourceModel\Profile'
        );
    }
}
