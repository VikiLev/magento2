<?php
namespace Name\CustomerComment\Plugin\Model\Checkout;

use Magento\Checkout\Api\GuestPaymentInformationManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;

/**
 * Class GuestValidation
 */
class GuestValidation
{
	/**
	 * @var CartRepositoryInterface
	 */
	protected $cartRepository;

	/**
	 * @var QuoteIdMaskFactory
	 */
	protected $quoteIdMaskFactory;

	public $customerSession;

	/**
	 */
	public function __construct(
		CartRepositoryInterface $cartRepository,
		QuoteIdMaskFactory $quoteIdMaskFactory,
        Session $session
	) {
        $this->customerSession = $session;
		$this->cartRepository = $cartRepository;
		$this->quoteIdMaskFactory = $quoteIdMaskFactory;
	}

	/**
	 * @param GuestPaymentInformationManagementInterface $subject
	 * @param int $cartId
	 * @param PaymentInterface $paymentMethod
	 * @param AddressInterface|null $billingAddress
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function beforeSavePaymentInformationAndPlaceOrder(
		GuestPaymentInformationManagementInterface $subject,
		$cartId,
		$email,
		PaymentInterface $paymentMethod,
		AddressInterface $billingAddress = null
	) {
		$this->addCustomerCommentToQuote($cartId, $paymentMethod);
	}

	/**
	 * @param GuestPaymentInformationManagementInterface $subject
	 * @param int $cartId
	 * @param PaymentInterface $paymentMethod
	 * @param AddressInterface|null $billingAddress
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function beforeSavePaymentInformation(
		GuestPaymentInformationManagementInterface $subject,
		$cartId,
		$email,
		PaymentInterface $paymentMethod,
		AddressInterface $billingAddress = null
	) {
		$this->addCustomerCommentToQuote($cartId, $paymentMethod);
	}

	/**
	 * @param int $cartId
	 * @param PaymentInterface $paymentMethod
	 * @throws \Magento\Framework\Exception\CouldNotSaveException
	 * @return void
	 */
	protected function addCustomerCommentToQuote($cartId, PaymentInterface $paymentMethod)
	{
		if (!$paymentMethod->getExtensionAttributes()) {
			return;
		}

		$customer_comment = $paymentMethod->getExtensionAttributes()->getCustomerComment();
        $quoteId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
        $quote = $this->cartRepository->getActive($quoteId);



		try {
			$quote->setCustomerComment($customer_comment);
			$quote->save();
		}
		catch (Exception $e) {
			throw new \Magento\Framework\Exception\CouldNotSaveException(
				__('Error saving customer comment.')
			);
		}
	}

}
