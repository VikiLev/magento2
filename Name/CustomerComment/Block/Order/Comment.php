<?php

namespace Name\CustomerComment\Block\Order;

use Magento\Framework\View\Element\Template;
use Web\CommentCheckout\Model\Data\OrderComment;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Sales\Model\Order;

/**
 * Class Comment
 * @package Name\CustomerComment\Block\Order
 */
class Comment extends Template
{

    const COMMENT_FIELD_NAME = 'customer_comment';
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * Comment constructor.
     * @param TemplateContext $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        TemplateContext $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->_isScopePrivate = true;
        $this->_template = 'order/view/comment.phtml';
        parent::__construct($context, $data);
    }

    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }

    public function getOrderComment()
    {
        return trim($this->getOrder()->getData(self::COMMENT_FIELD_NAME));
    }

}
