<?php

namespace Web\HidePrice\Plugin;


//use Magento\Catalog\Model\Product;
//use Web\HidePrice\Helper\Data;
//
//class Price
//
//{
//    public  $helperData;
//    public $product;
//
//    public function __construct(Data $helperData, Product $product){
//        $this->helperData = $helperData;
//        $this->product = $product;
//    }
//    public function afterGetPrice($product, $result)
//    {
//        $status = $this->helperData->getIsEnable();
//        $log = $this->helperData->isLog();
//        if(!$status || $log){
//            return $result;
//        }
//        return $result * 0;
//    }
//}
