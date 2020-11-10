<?php
namespace Name\CustomerComment\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SalesModelServiceQuoteSubmitBefore
 * @package Name\CustomerComment\Observer
 */
class SalesModelServiceQuoteSubmitBefore implements ObserverInterface
{
	/**
	 * @param EventObserver $observer
	 * @return $this
	 */
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		$quote = $observer->getEvent()->getQuote();
		$order = $observer->getEvent()->getOrder();
		$order->setCustomerComment($quote->getCustomerComment());

		return $this;
	}
}
