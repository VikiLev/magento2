<?php

namespace W4PLEGO\Base\Service;

use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;

/**
 *  GetCurrentCategoryService
 */
class GetCurrentCategoryService
{
    /**
     * @var CategoryInterface
     */
    private $category;

    /**
     * @var CategoryInterfaceFactory
     */
    private $categoryFactory;

    /**
     * CurrentProduct constructor.
     * @param CategoryInterfaceFactory $categoryFactory
     */
    public function __construct(CategoryInterfaceFactory $categoryFactory)
    {
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @param CategoryInterface $category
     */
    public function set(CategoryInterface $category): void
    {
        $this->category = $category;
    }

    /**
     * @return CategoryInterface
     */
    private function createNullCategory(): CategoryInterface
    {
        return $this->categoryFactory->create();
    }

    /**
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->getCategory()->getId();
    }

    /**
     * @return CategoryInterface
     */
    public function getCategory() : CategoryInterface
    {
        return $this->category ?? $this->createNullCategory();
    }
}
