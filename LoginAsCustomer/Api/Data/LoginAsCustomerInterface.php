<?php


namespace Web\LoginAsCustomer\Api\Data;

interface LoginAsCustomerInterface
{
    const ENTITY_ID = 'entity_id';
    const CUSTOMER_ID = 'customer_id';
    const CUSTOMER_NAME = 'customer_name';
    const ADMIN_ID = 'admin_id';
    const ADMIN_USERNAME = 'admin_username';
    const SECRET = 'secret';
    const LOGGED_AT = 'logged_at';
    const CUSTOMER_EMAIL = 'customer_email';


    public function getLoginAsCustomerId();
    public function setLoginAsCustomerId($loginAsCustomerId);


    public function getCustomerId();
    public function setCustomerId($customerId);


    public function getCustomerName();
    public function setCustomerName($customerName);

    public function getCustomerEmail();
    public function setCustomerEmail($customerEmail);


    public function getAdminId();
    public function setAdminId($adminId);


    public function getAdminUserName();
    public function setAdminUserName($adminUserName);


    public function getSecret();
    public function setSecret($secret);


    public function getLoggedAt();
    public function setLoggedAt($loggedAt);


}
