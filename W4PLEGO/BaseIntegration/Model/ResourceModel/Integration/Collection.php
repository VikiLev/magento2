<?php

namespace W4PLEGO\BaseIntegration\Model\ResourceModel\Integration;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use W4PLEGO\BaseIntegration\Model\Integration;
use W4PLEGO\BaseIntegration\Model\ResourceModel\Integration as ResourceModelIntegration;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Integration::class, ResourceModelIntegration::class);
    }
}
