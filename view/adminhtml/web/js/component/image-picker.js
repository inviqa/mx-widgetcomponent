define([
    'jquery',
    'mage/adminhtml/browser',
    'jquery/ui',
], function ($) {
    'use strict';

    var $widget,
        $input,
        $label,
        $button,
        $previewImage;

    $.widget('mx.widgetComponentImagePicker', {
        options: {
            url: '',
            targetId: '',
            baseMediaUrl: ''
        },

        /**
         * Gallery creation
         * @protected
         */
        _create: function () {
            $widget = this;
            $input = $('#' + this.options.targetId);
            $label = $input.prev();
            $button = $('#' + this.options.targetId + '_button');
            $previewImage = $('#' + this.options.targetId + '_preview_image');

            this._bind();
        },

        /**
         * Bind handler to elements
         * @protected
         */
        _bind: function () {
            $input.on('change', function() {
                var newValue = $input.val();

                if (newValue == '') {
                    return;
                }

                $label.text(newValue);

                if ($previewImage.length) {
                    var imageUrl = $widget._getImageUrl(newValue)
                    $previewImage.attr('src', imageUrl);

                    if (!$widget._isValidImage(imageUrl)) {
                        $input.val('');
                        $previewImage.attr('src', '');
                    }
                }
            });

            $button.on('click', function() {
                $widget._openDialog();
            });
        },

        _openDialog: function() {
            MediabrowserUtility.openDialog($widget.options.url);
        },

        _getImageUrl: function(imagePath) {
            return $widget.options.baseMediaUrl + imagePath;
        },

        _isValidImage: function(imageUrl) {
            return imageUrl.indexOf('wysiwyg') !== -1;
        }
    });

    return $.mx.widgetComponentImagePicker;
});
