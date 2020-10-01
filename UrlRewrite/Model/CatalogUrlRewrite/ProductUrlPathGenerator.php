<?php

namespace Web\UrlRewrite\Model\CatalogUrlRewrite;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use \Web\UrlRewrite\Helper\Data;
/**
 * Class ProductUrlPathGenerator
 * @package Web\UrlRewrite\Model\CatalogUrlRewrite
 */
class ProductUrlPathGenerator extends \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator
{
    /**
     * @var Data
     */
    public $helper;
    /**
     * ProductUrlPathGenerator constructor.
     * @param \Web\UrlRewrite\Helper\Data $helper
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param CategoryUrlPathGenerator $categoryUrlPathGenerator
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Data $helper,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        CategoryUrlPathGenerator $categoryUrlPathGenerator,
        ProductRepositoryInterface $productRepository
    ) {
        $this->helper = $helper;
        parent::__construct($storeManager, $scopeConfig, $categoryUrlPathGenerator, $productRepository);
    }
    /**
     * Retrieve Product Url path (with category if exists)
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Catalog\Model\Category $category
     *
     * @return string
     */
    public function getUrlPath($product, $category = null)
    {
        $prefix = $this->helper->getPrefix();
        $prefixCat = $this->helper->getPrefixCategory();

        $path = $product->getData('url_path');
        if ($path === null) {
            $path = $product->getUrlKey()
                ? $this->prepareProductUrlKey($product)
                : $this->prepareProductDefaultUrlKey($product);
        }
        if ($category !== null) {
            $categoryUrl = str_replace($prefixCat .'/','',$this->categoryUrlPathGenerator->getUrlPath($category));
            $path = $categoryUrl . '/' . $path;
        }
        return $prefix. '/' . $path;
    }
}
