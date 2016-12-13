define([
    'jquery',
    'mage/adminhtml/browser',
    'jquery/ui',
], function ($) {
    'use strict';

    $.widget('mx.widgetComponentImagePicker', {
        options: {
            baseMediaUrl: ''
        },

        /**
         * Gallery creation
         * @protected
         */
        _create: function () {
            this._bind();
        },

        /**
         * Bind handler to elements
         * @protected
         */
        _bind: function () {
            var $image = this.element.find('img'),
                imageUrl,
                input = this.element.prev(),
                $this = this;

            input.on('change', function() {
                if ($(this).val() == '') {
                    return;
                }

                $(this).prev().text(input.val());

                if ($image.length) {
                    imageUrl = $this.options.baseMediaUrl + input.val();
                    $image.attr('src', imageUrl);

                    if (!$this.isValidImage(imageUrl)) {
                        $(this).val('');
                        $image.attr('src', '');
                    }
                }
            });
        },

        isValidImage: function(imageUrl) {
            return imageUrl.indexOf('wysiwyg') !== -1;
        }
    });

    return $.mx.widgetComponentImagePicker;
});
