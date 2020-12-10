<?php

namespace W4PLEGO\BaseIntegration\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Scheduler extends AbstractDb
{
    /**
     * Resource initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_init('w4plego_integrations_cron_schedule', 'id');
    }

    /**
     * @param int $integrationId
     * @return string
     */
    public function getScheduleIdByIntegrationId($integrationId)
    {
        $select = $this->getConnection()->select()->from(
            ['schedule' => $this->getTable('w4plego_integrations_cron_schedule')],
            ['id']
        )->where(
            'integration_id = ?',
            $integrationId
        );

        return $this->getConnection()->fetchOne($select);
    }
}
