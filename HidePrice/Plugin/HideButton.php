<?php
namespace Web\HidePrice\Plugin;
use Magento\Catalog\Model\Product;
use Web\HidePrice\Helper\Data;

class HideButton
{
    public  $helperData;
    public $product;

    public function __construct(Data $helperData, Product $product){
        $this->helperData = $helperData;
        $this->product = $product;
    }

    public function afterIsSaleable(Product $product)
    {
        $status = $this->helperData->getIsEnable();
        $log = $this->helperData->isLog();
        if(!$status || $log){
            return $this->product->isSalable();
        }
        return [];
    }
}