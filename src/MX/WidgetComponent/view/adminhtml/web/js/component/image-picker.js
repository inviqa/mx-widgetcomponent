define([
    'jquery',
    'mage/adminhtml/browser',
    'jquery/ui',
], function ($) {
    'use strict';

    $.widget('mx.widgetComponentImagePicker', {
        options: {
            url: '',
            targetId: '',
            baseMediaUrl: ''
        },

        input: "",
        label: "",
        button: "",
        previewImage: "",

        /**
         * Gallery creation
         * @protected
         */
        _create: function () {
            this.input = $('#' + this.options.targetId);
            this.label = this.input.prev();
            this.button = $('#' + this.options.targetId + '_button');
            this.previewImage = $('#' + this.options.targetId + '_preview_image');

            this._bind();
        },

        /**
         * Bind handler to elements
         * @protected
         */
        _bind: function () {
            var $widget = this;
            this.input.on('change', function() {
                var newValue = $widget.input.val();

                if (newValue == '') {
                    return;
                }

                $widget.label.text(newValue);

                if ($widget.previewImage.length) {
                    var imageUrl = $widget._getImageUrl(newValue)
                    $widget.previewImage.attr('src', imageUrl);

                    if (!$widget._isValidImage(imageUrl)) {
                        $widget.input.val('');
                        $widget.previewImage.attr('src', '');
                    }
                }
            });

            $widget.button.on('click', function() {
                $widget._openDialog();
            });
        },

        _openDialog: function() {
            MediabrowserUtility.openDialog(this.options.url);
        },

        _getImageUrl: function(imagePath) {
            return this.options.baseMediaUrl + imagePath;
        },

        _isValidImage: function(imageUrl) {
            return imageUrl.indexOf('wysiwyg') !== -1;
        }
    });

    return $.mx.widgetComponentImagePicker;
});
