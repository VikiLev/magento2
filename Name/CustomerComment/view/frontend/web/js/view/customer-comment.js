define(
    [
        'ko',
        'jquery',
        'uiComponent'
    ],
    function (ko, $, Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Name_CustomerComment/checkout/customer_comment'
            }
        });
    }
);
