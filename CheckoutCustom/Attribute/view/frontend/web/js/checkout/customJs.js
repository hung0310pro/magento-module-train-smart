define(
    [
        'ko',
        'jquery',
        'uiComponent',
        'mage/url',
        'jquery/jquery.cookie'
    ],
    function (ko, $, Component, url) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'CheckoutCustom_Attribute/checkout/customCheckbox'
            },
            initObservable: function () {

                this._super()
                    .observe({
                        CheckVals: ko.observable(false) //default checked(true)
                    });
                var checkVal = 0;
                $.cookieStorage.set('agree_cookie', checkVal);
                self = this;
                this.CheckVals.subscribe(function (newValue) {
                    var linkUrls = url.build('Attribute/Checkout/SaveInQuote');
                    if (newValue) {
                        checkVal = 1;
                    } else {
                        checkVal = 0;
                    }
                    $.cookieStorage.set('agree_cookie', checkVal);

                   /* $.ajax({
                        showLoader: true,
                        url: linkUrls,
                        data: {checkVal: checkVal},
                        type: "POST",
                        dataType: 'json'
                    }).done(function (data) {
                        console.log('success');
                    });*/
                });
                return this;
            }
        });
    });