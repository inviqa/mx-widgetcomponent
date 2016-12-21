define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'jquery/ui',
    'mage/validation',
    'mage/translate',
    'Magento_Ui/js/modal/modal',
    'mage/adminhtml/browser'
], function($, alert) {
    'use strict';

    var $form,
        $input,
        $button;

    $.widget('mx.widgetComponentSubWidget', {
        options: {
            url: '',
            targetId: ''
        },

        _create: function() {
            $form = $('#widget_options_form');
            if (this._insertFormDisplayed()) {
                $form = $('#' + this.options.targetId + '_options_form');
            }

            if (this.options.targetId !== '') {
                $input = $('#' + this.options.targetId);
                $button = $('#' + this.options.targetId + '_button');
            }

            this._bind();
        },

        _bind: function() {
            var $this = this;

            if (this._insertFormDisplayed()) {
                $('.content-footer').find('button').click(function() {
                    $this._insertWidget();
                });
            } else {
                $button.on('click', function() {
                    $this._openDialog();
                });
            }
        },

        _insertWidget: function() {
            var $this = this;

            $form.validate({
                ignore: ".skip-submit",
                errorClass: 'mage-error'
            });

            var validationResult = $form.valid();
            if (validationResult) {
                var params = $form.find('input, textarea, select').not('.skip-submit');

                $.ajax({
                   url: $form.attr('action'),
                    data: params.serialize(),
                    complete: function(response) {
                        try {
                            $this._closeDialog();
                            $input.val(response.responseText);
                            $input.prev('.control-value').html(response.responseText);
                        } catch (e) {
                            alert({
                                content: e.message
                            });
                        }
                    }
                });
            }
        },

        _openDialog: function() {
            if (this.dialogOpened) {
                return;
            }

            var $this = this,
                formKey = $('input[name="form_key"]:first').val(),
                widgetUrl = this.options.url + 'widget_values/' + encodeURIComponent(this.element.val());

            this.dialogWindow = $('<div/>').modal({
                title: $.mage.__('SubWidget configuration...'),
                type: 'slide',
                buttons: [],
                opened: function () {
                    var dialog = $(this).addClass('loading magento-message');
                    $.ajax({
                        url : widgetUrl,
                        data: {'form_key': formKey},
                        complete: function(response) {
                            dialog.removeClass('loading');
                            $(dialog).html(response.responseText);
                        }
                    });
                },
                closed: function (e, modal) {
                    $this._closeDialog(modal);
                }
            });

            this.dialogOpened = true;
            this.dialogWindow.modal('openModal');
        },

        _closeDialog: function(modal) {
            if (typeof modal !== 'undefined') {
                modal.modal.remove();
            } else {
                if (typeof this.dialogWindow !== 'undefined') {
                    this.dialogWindow.modal('closeModal');
                } else {
                    this.element.closest('[data-role="modal"]').find('.action-close').trigger('click');
                }
            }

            this.dialogOpened = false;

            this._bind(); // Re-bind everything after close
        },

        _insertFormDisplayed: function() {
            return (this.options.targetId !== '' && $('#' + this.options.targetId + '_options_form').length);
        }
    });

    return $.mx.widgetComponentSubWidget;
});