<?php

namespace W4PLEGO\Base\Service;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;

/**
 *  CurrentProductDataProvider
 */
class GetCurrentProductService
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var ProductInterfaceFactory
     */
    private $productFactory;

    /**
     * CurrentProduct constructor.
     * @param ProductInterfaceFactory $productFactory
     */
    public function __construct(ProductInterfaceFactory $productFactory)
    {
        $this->productFactory = $productFactory;
    }

    /**
     * @param ProductInterface $product
     */
    public function set(ProductInterface $product): void
    {
        $this->product = $product;
    }

    /**
     * @return ProductInterface
     */
    private function createNullProduct(): ProductInterface
    {
        return $this->productFactory->create();
    }

    /**
     * @return int|null
     */
    public function getProductId()
    {
        return $this->getProduct()->getId();
    }

    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product ?? $this->createNullProduct();
    }
}
