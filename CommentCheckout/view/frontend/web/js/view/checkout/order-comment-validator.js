define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Web_CommentCheckout/js/model/checkout/order-comment-validator'
    ],
    function (Component, additionalValidators, commentValidator) {
        'use strict';

        additionalValidators.registerValidator(commentValidator);

        return Component.extend({});
    }
);
