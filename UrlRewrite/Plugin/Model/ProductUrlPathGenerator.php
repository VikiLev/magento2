<?php

namespace Web\UrlRewrite\Plugin\Model;
use Magento\Framework\App\Response\Http;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Web\UrlRewrite\Helper\Data;

/**
 * Class ProductUrlPathGenerator
 * @package Web\UrlRewrite\Plugin\Model
 */
class ProductUrlPathGenerator
{
    /**
     * @var Data
     */
    public $helper;
    /**
     * @var StoreManager
     */
    public $_storeManager;
    /**
     * @var Http
     */
    public $response;

    /**
     * ProductUrlPathGenerator constructor.
     * @param StoreManager $_storeManager
     * @param Data $helper
     * @param Http $response
     */
    public function __construct(
        StoreManager $_storeManager,
        Data $helper,
        Http $response
    )
    {
        $this->helper = $helper;
        $this->_storeManager = $_storeManager;
        $this->response = $response;
    }
    /**
     * @param \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function afterGetUrlPath(\Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject, $path)
    {
        $prefix = $this->helper->getPrefix();
        if (strpos($path, $prefix) === false){
            $path = $prefix . $path;}
        return $path;
    }
}
