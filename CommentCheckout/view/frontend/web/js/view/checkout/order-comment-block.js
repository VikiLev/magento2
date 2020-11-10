define(
    [
        'jquery',
        'uiComponent',
        'knockout'
    ],
    function ($, Component, ko) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Web_CommentCheckout/checkout/order-comment-block'
            },
        });
    }
);
