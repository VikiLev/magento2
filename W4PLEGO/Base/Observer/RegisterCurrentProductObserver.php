<?php

namespace W4PLEGO\Base\Observer;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;
use W4PLEGO\Base\Service\GetCurrentProductService;

class RegisterCurrentProductObserver implements ObserverInterface
{
    /**
     * @var GetCurrentProductService
     */
    private $currentProduct;

    /**
     * RegisterCurrentProductObserver constructor.
     * @param GetCurrentProductService $currentProduct
     */
    public function __construct(GetCurrentProductService $currentProduct)
    {
        $this->currentProduct = $currentProduct;
    }

    /**
     * @param Event $event
     */
    public function execute(Event $event)
    {
        /** @var ProductInterface $product */
        $product = $event->getData('product');
        $this->currentProduct->set($product);
    }
}
