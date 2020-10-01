<?php
namespace Web\UrlRewrite\Plugin\Model;
use Magento\Framework\App\Response\Http;
use Web\UrlRewrite\Helper\Data;
use Magento\Store\Model\StoreManagerInterface as StoreManager;

/**
 * Class CategoryUrlPathGenerator
 * @package Web\UrlRewrite\Plugin\Model
 */
class CategoryUrlPathGenerator
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
     * CategoryUrlPathGenerator constructor.
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
     * @param \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function afterGetUrlPath(\Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject, $path)
    {
        $prefixCat = $this->helper->getPrefixCategory();
        if (strpos($path, $prefixCat) === false)
            $path = $prefixCat . $path;
        return $path;
    }
}
