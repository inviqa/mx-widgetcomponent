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

    var formId,
        $input,
        $button,
        $widget;

    $.widget('mx.widgetComponentSubWidget', {
        options: {
            url: '',
            targetId: ''
        },

        _create: function() {
            $widget = this;
            $input = $('#' + this.options.targetId);
            $button = $('#' + this.options.targetId + '_button');
            formId = '#' + this.options.targetId + '_options_form';

            $button.on('click', function() {
                $widget._openDialog();
            });
        },

        _insertWidget: function() {
            var $form = $(formId);

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
                            $widget._closeDialog();
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

            var formKey = $('input[name="form_key"]:first').val(),
                widgetUrl = this.options.url + '?widget_values=' + encodeURIComponent($input.val());

            this.dialogWindow = $('<div/>').modal({
                title: $.mage.__('SubWidget configuration...'),
                type: 'slide',
                buttons: [{
                    text: $.mage.__('Insert'),
                    'class': 'action save',
                    click: function() {
                        $widget._insertWidget();
                    }
                }],
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
                    $widget._closeDialog(modal);
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
        }
    });

    return $.mx.widgetComponentSubWidget;
});