define(
    [
        'jquery',
        'uiComponent',
        'Magento_Customer/js/customer-data'
    ],
    function ($, Component, customerData) {
        'use strict';
        return Component.extend({
            defaults: {
                plausible: {}
            },

            initialize: function () {
                this._super();

                this.plausible = customerData.get('plausible');
                this.plausible.subscribe(function (result) {
                    $.each(result.goals, function(name, params) {
                        plausible(name, params);
                    });
                });

                if (!_.isEmpty(this.plausible().goals)) {
                    customerData.set('plausible', {});
                }

                if (this.reload) {
                    customerData.reload(['plausible'], false);
                }
            }
        });
    }
);
