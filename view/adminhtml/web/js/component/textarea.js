define([
    'jquery',
    'jquery/ui',
], function ($) {
    'use strict';

    $.widget('mx.widgetComponentTextarea', {
        _create: function () {
            this._bind();
        },

        /**
         * Bind handler to elements
         * @protected
         */
        _bind: function () {
            var left;

            this.element.keyup(function () {
                left = $(this).attr('maxlength') - $(this).val().length;
                if (left < 0) {
                    left = 0;
                }

                $(this).prev().text("Characters left: " + left);
            });
        }
    });

    return $.mx.widgetComponentTextarea;
});
