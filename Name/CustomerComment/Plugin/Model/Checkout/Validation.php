<?php
namespace Name\CustomerComment\Plugin\Model\Checkout;

use Magento\Checkout\Api\PaymentInformationManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;

/**
 * Class Validation
 */
class Validation
{
	/**
	 * @var CartRepositoryInterface
	 */
	protected $cartRepository;

	/**
	 */
	public function __construct(
		CartRepositoryInterface $cartRepository
	) {
		$this->cartRepository = $cartRepository;
	}

	/**
	 * @param PaymentInformationManagementInterface $subject
	 * @param int $cartId
	 * @param PaymentInterface $paymentMethod
	 * @param AddressInterface|null $billingAddress
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function beforeSavePaymentInformationAndPlaceOrder(
		PaymentInformationManagementInterface $subject,
		$cartId,
		PaymentInterface $paymentMethod,
		AddressInterface $billingAddress = null
	) {
		$this->addCustomerCommentToQuote($cartId, $paymentMethod);
	}

	/**
	 * @param PaymentInformationManagementInterface $subject
	 * @param int $cartId
	 * @param PaymentInterface $paymentMethod
	 * @param AddressInterface|null $billingAddress
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function beforeSavePaymentInformation(
		PaymentInformationManagementInterface $subject,
		$cartId,
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
		$quote = $this->cartRepository->getActive($cartId);

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
