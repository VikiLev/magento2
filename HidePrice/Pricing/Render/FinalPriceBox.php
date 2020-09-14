<?php

namespace Web\HidePrice\Pricing\Render;
use Magento\Bundle\Pricing\Price\FinalPrice;
use Magento\Catalog\Pricing\Price;
use Magento\Catalog\Pricing\Price\CustomOptionPrice;
use Magento\Framework\Pricing\Render;
use Magento\Framework\Pricing\Render\PriceBox as BasePriceBox;
use Magento\Msrp\Pricing\Price\MsrpPrice;
use Web\HidePrice\Helper\Data;


class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    protected $customerSession;
    protected $helperData;

    public function __construct(
        Data $helperData,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Magento\Framework\Pricing\SaleableInterface $saleableItem,
        \Magento\Framework\Pricing\Price\PriceInterface $price,
        \Magento\Framework\Pricing\Render\RendererPool $rendererPool,
        array $data = [],
        \Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface $salableResolver = null,
        \Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface $minimalPriceCalculator = null
    )
    {
        parent::__construct($context, $saleableItem, $price, $rendererPool, $data, $salableResolver, $minimalPriceCalculator);
        $this->customerSession = $customerSession;
        $this->helperData = $helperData;
    }


    protected function wrapResult($html)
    {
        $status = $this->helperData->getIsEnable();
        $session = $this->helperData->isLog();

        if ($session || !$status){
            return '<div class="price-box ' . $this->getData('css_classes') . '" ' .
                'data-role="priceBox" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . $html . '</div>';
        } else {
            return '<div class="" ' .
                'data-role="priceBox" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . '<strong>Log in to see the price</strong>' . '</div>';
        }
    }

    public function showRangePrice()
    {
        return "";
    }

}