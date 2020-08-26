<?php

namespace Web\Attribute\Block\Category;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model;

class ListCategory extends Template
{

    /**
     * @var Category $currentCategory
     */
    protected $currentCategory;

    /**
     * @var Resolver $layerResolver
     */
    protected $layerResolver;

    /**
     * ListCategory constructor.
     * @param Context $context
     * @param Resolver $layerResolver
     * @param array $data
     */
    public function __construct(
        Context $context,
        Resolver $layerResolver,
        array $data = []
    ) {
        $this->layerResolver = $layerResolver;
        parent::__construct($context, $data);
    }

    public function getCategoryImageUrl()
    {
        if (!$this->currentCategory) {
            $this->currentCategory = $this->layerResolver->get()->getCurrentCategory()->getImageUrl('custom_image');
        }
        return $this->currentCategory;
    }
}