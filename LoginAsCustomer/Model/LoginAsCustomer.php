<?php


namespace Web\LoginAsCustomer\Model;

use Web\LoginAsCustomer\Api\Data\LoginAsCustomerInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class LoginAsCustomer extends \Magento\Framework\Model\AbstractModel implements LoginAsCustomerInterface
{
    protected $customerFactory;
    protected $customerSession;
    protected $customer;
    protected $dateTime;
    protected $random;
    protected $cart;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Framework\Math\Random $random,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
        $this->dateTime = $dateTime;
        $this->random = $random;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Web\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer');
    }


    public function getLoginAsCustomerId()
    {
        return $this->getData(self::ENTITY_ID);
    }
    public function setLoginAsCustomerId($loginAsCustomerId)
    {
        return $this->setData(self::ENTITY_ID, $loginAsCustomerId);
    }
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }
    public function getCustomerName()
    {
        return $this->getData(self::CUSTOMER_NAME);
    }
    public function setCustomerName($customerName)
    {
        return $this->setData(self::CUSTOMER_NAME, $customerName);
    }
    public function getAdminUserName()
    {
        return $this->getData(self::ADMIN_USERNAME);
    }
    public function setAdminUserName($adminUserName)
    {
        return $this->setData(self::ADMIN_USERNAME, $adminUserName);
    }
    public function getCustomerEmail()
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }
    public function getSecret()
    {
        return $this->getData(self::SECRET);
    }
    public function setSecret($secret)
    {
        return $this->setData(self::SECRET, $secret);
    }
    public function getLoggedAt()
    {
        return $this->getData(self::LOGGED_AT);
    }
    public function setLoggedAt($loggedAt)
    {
        return $this->setData(self::LOGGED_AT, $loggedAt);
    }
    public function getAdminId()
    {
        return $this->getData(self::ADMIN_ID);
    }
    public function setAdminId($adminId)
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * @param $secret
     * @return \Magento\Framework\DataObject
     */
    public function loadNotUsed($secret)
    {
        return $this->getCollection()
            ->addFieldToFilter('secret', $secret)
            ->setPageSize(1)
            ->getFirstItem();
    }

    /**
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        if ($this->customer === null) {
            $this->customer = $this->customerFactory->create()
                ->load($this->getCustomerId());
        }
        return $this->customer;
    }

    /**
     * @return \Magento\Customer\Model\Customer
     * @throws NoSuchEntityException
     */
    public function authenticateCustomer()
    {
        $customer = $this->getCustomer();
        if (!$customer->getId()) {
            throw new NoSuchEntityException(__("Customer are no longer exist."), 1);
        }
        if ($this->customerSession->loginById($customer->getId())) {
            $this->customerSession->regenerateId();
            $this->customerSession->setLoggedAsCustomerAdmindId(
                $this->getAdminId()
            );
        }
        return $customer;
    }

    /**
     * @param $adminUserName
     * @param $customerEmail
     * @param $customerName
     * @return LoginAsCustomer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function generate( $adminUserName,  $customerEmail, $customerName)
    {
        return $this->setData([
            'customer_id' => $this->getCustomerId(),
            'customer_email' => $customerEmail,
            'customer_name' => $customerName,
            'admin_username' => $adminUserName,
            'secret' => $this->random->getRandomString(64),
            'logged_at' => $this->dateTime->gmtTimestamp(),
        ])->save();
    }
}
