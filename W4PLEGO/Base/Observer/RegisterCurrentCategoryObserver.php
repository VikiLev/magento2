<?php

namespace W4PLEGO\Base\Observer;

use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;
use W4PLEGO\Base\Service\GetCurrentCategoryService;

class RegisterCurrentCategoryObserver implements ObserverInterface
{
    /**
     * @var GetCurrentCategoryService
     */
    private $currentCategory;

    /**
     * RegisterCurrentCategoryObserver constructor.
     * @param GetCurrentCategoryService $currentCategory
     */
    public function __construct(GetCurrentCategoryService $currentCategory)
    {
        $this->currentCategory = $currentCategory;
    }

    /**
     * @param Event $event
     */
    public function execute(Event $event)
    {
        /** @var CategoryInterface $category */
        $category = $event->getData('category');
        $this->currentCategory->set($category);
    }
}
