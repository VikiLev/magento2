<?php

namespace W4PLEGO\BaseIntegration\Model\ResourceModel\Scheduler;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use W4PLEGO\BaseIntegration\Model\Scheduler;
use W4PLEGO\BaseIntegration\Model\ResourceModel\Scheduler as ResourceModelScheduler;

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
        $this->_init(Scheduler::class, ResourceModelScheduler::class);
    }
}
