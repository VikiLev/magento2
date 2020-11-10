<?php

namespace Web\CommentCheckout\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;


class LayoutProcessorPlugin
{
    protected $logger;

    public function __construct(\Psr\Log\LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function afterProcess(LayoutProcessor $subject, array $jsLayout)
    {
//        $customAttributeCode = 'customvar';
        $customAttributeCode = 'web_order_comment';

        $customField = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'comment.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'tooltip' => [
                    'description' => 'this is custom var field',
                ],
            ],

            'dataScope' => 'comment.custom_attributes' . '.' . $customAttributeCode,
            'label' => 'Do you have any comments regarding the order?',
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'validation' => [
                'required-entry' => false
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']
        ['billing-step']['children']['payment']['children']['beforeMethods']['children'][$customAttributeCode] = $customField;

        return $jsLayout;
    }
}
