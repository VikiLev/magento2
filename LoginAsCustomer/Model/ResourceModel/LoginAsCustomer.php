<?php


namespace Web\LoginAsCustomer\Model\ResourceModel;

class LoginAsCustomer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{


    protected function _construct()
    {
        $this->_init('web_login_as_customer', 'entity_id');
    }
}
