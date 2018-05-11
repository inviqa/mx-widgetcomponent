define([
    'jquery',
    'mage/adminhtml/browser',
    'jquery/ui',
], function ($) {
    'use strict';

    $.widget('mx.widgetComponentMediaPicker', {
        options: {
            url: '',
            targetId: '',
            baseMediaUrl: ''
        },

        input: "",
        label: "",
        button: "",
        removeLink: "",
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
            this.previewVideo = $('#' + this.options.targetId + '_preview_video');
            this.removeLink = this.button.next('div').find('.remove-media');

            this._bind();
        },

        /**
         * Bind handler to elements
         * @protected
         */
        _bind: function () {
            var $widget = this;

            this._toggleRemoveLink(this.input);

            this.input.on('change', function() {
                var newValue = $widget.input.val();

                if (newValue == '') {
                    return;
                }

                $widget.label.text(newValue);

                // Image picker preview
                if ($widget.previewImage.length) {
                    var imageUrl = $widget._getMediaUrl(newValue)
                    $widget.previewImage.attr('src', imageUrl);

                    if (!$widget._isValidImage(imageUrl)) {
                        $widget.input.val('');
                        $widget.previewImage.attr('src', '');
                    }
                }

                // video picker preview
                if ($widget.previewVideo.length) {
                    var previewUrl = $widget.previewVideo.data('img-src');
                    $widget.previewVideo.attr('src', previewUrl);
                }

                $widget.removeLink.show();
            });

            this.removeLink.on('click', function(e) {
                var value = $(e.target).data('target'),
                    $input = $('#' + value.replace(/_remove_(image|video)/, '')),
                    $image = $('#' + value.replace(/_remove_/, '_preview_')),
                    $label;

                if ($input.length) {
                    $input.val('');
                }

                if ($image.length && !$image.data('video-src')) {
                    $image.attr('src', '');
                }

                $label = $input.prev('.control-value');
                if ($label.length) {
                    $label.html('');
                }

                $(e.target).hide();
            });

            this.previewVideo.on('click', function(e) {
                var url = $widget.input.val();

                if (url) {
                    window.open($widget._getMediaUrl(url));
                }
            });

            $widget.button.on('click', function() {
                $widget._openDialog();
            });
        },

        _toggleRemoveLink: function($input) {
            if ($input.val() !== '') {
                $input.closest('.control').find('.remove-media').show();
            }
        },

        _openDialog: function() {
            MediabrowserUtility.openDialog(this.options.url);
        },

        _getMediaUrl: function(mediaPath) {
            return this.options.baseMediaUrl + mediaPath;
        },

        _isValidImage: function(imageUrl) {
            return imageUrl.indexOf('wysiwyg') !== -1;
        }
    });

    return $.mx.widgetComponentMediaPicker;
});
