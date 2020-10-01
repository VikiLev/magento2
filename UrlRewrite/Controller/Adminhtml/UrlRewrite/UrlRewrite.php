<?php

namespace Web\UrlRewrite\Controller\Adminhtml\UrlRewrite;

use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\UrlRewrite\Model\UrlPersistInterface;

/**
 * Class UrlRewrite
 * @package Web\UrlRewrite\Controller\Adminhtml\UrlRewrite
 */
class UrlRewrite extends Action
{
    /**
     * @var ProductUrlRewriteGenerator
     */
    public $_productUrlRewriteGenerator;
    /**
     * @var UrlPersistInterface
     */
    public $urlPersist;
    /**
     * @var Collection
     */
    public $collection;

    /**
     * UrlRewrite constructor.
     * @param Collection $collection
     * @param UrlPersistInterface $urlPersist
     * @param ProductUrlRewriteGenerator $_productUrlRewriteGenerator
     * @param Context $context
     */
    public function __construct(
        Collection $collection,
        UrlPersistInterface $urlPersist,
        ProductUrlRewriteGenerator $_productUrlRewriteGenerator,
        Context $context)
    {
        $this->collection = $collection;
        $this->urlPersist = $urlPersist;
        $this->_productUrlRewriteGenerator = $_productUrlRewriteGenerator;
        return parent::__construct($context);
    }

    public function execute()
    {
        $this->collection->addAttributeToSelect(['url_path', 'url_key']);
        $collectionProduct = $this->collection->load();
        foreach($collectionProduct as $product) {
            $this->urlPersist->replace($this->_productUrlRewriteGenerator->generate($product));
        }
        $this->_redirect('catalog/product/');
    }
}





