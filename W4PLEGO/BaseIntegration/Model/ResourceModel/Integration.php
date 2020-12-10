<?php

namespace W4PLEGO\BaseIntegration\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Integration extends AbstractDb
{
    /**
     * Resource initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_init('w4plego_integrations', 'id');
    }
}
