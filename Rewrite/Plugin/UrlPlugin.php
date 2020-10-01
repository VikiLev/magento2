<?php

namespace Web\Rewrite\Plugin;
use Magento\Store\Model\StoreManagerInterface as StoreManager;

class UrlPlugin
{
    /**
     * Store manager
     *
     * @var StoreManager
     */
    protected $_storeManager;
    protected $response;
    protected $urlFactory;
    protected $helper;


    public function __construct(
        StoreManager $_storeManager,
        \Web\UrlRewrite\Helper\Data $helper,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\UrlFactory $urlFactory
    )
    {
        $this->helper = $helper;
        $this->urlFactory = $urlFactory;
        $this->_storeManager = $_storeManager;
        $this->response = $response;
    }

    /**
     * @param \Magento\Catalog\Model\Product\Url $subject
     * @param string $url
     * @return string
     */


    public function afterGetUrl(\Magento\Catalog\Model\Product\Url $subject, $url)
    {
        $prefix = $this->helper->getPrefix();
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        $urlRew =  str_replace($baseUrl, $prefix, $url);
        return $urlRew;


    }

}
