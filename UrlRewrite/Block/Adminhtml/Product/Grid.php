<?php

namespace  Web\UrlRewrite\Block\Adminhtml\Product;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\AuthorizationInterface;

/**
 * Class Grid
 * @package Web\UrlRewrite\Block\Adminhtml\Product
 */
class Grid extends GenericButton implements ButtonProviderInterface
{
    /**
     * @var AuthorizationInterface
     */
    protected $authorization;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var
     */
    protected $urlBuilder;
    /**
     * @var
     */
    protected $connector;

    /**
     * Grid constructor.
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        parent::__construct($context, $registry);
        $this->authorization = $context->getAuthorization();
        $this->scopeConfig = $context->getScopeConfig();
    }
    /**
     * @return array
     */
    public function getButtonData()
    {
        $urlData = $this->urlBuilder->getUrl(
            'web_urlrewrite/urlrewrite/urlrewrite'
        );
        $data = [
            'label' =>  __('Rewrite URL'),
            'on_click' => 'setLocation(\'' . $urlData . '\')',
            'class' => 'primary'
        ];
        return $data;
    }
}
