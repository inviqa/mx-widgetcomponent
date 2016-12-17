/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    "jquery",
    "tinymce",
    'Magento_Ui/js/modal/alert',
    "jquery/ui",
    "mage/translate",
    "mage/mage",
    "mage/validation",
    "mage/adminhtml/events",
    "prototype",
    'Magento_Ui/js/modal/modal'
], function(jQuery, tinyMCE, alert){
    var SubWidget = {};
    SubWidget.DialogHandler = Class.create();
    SubWidget.DialogHandler.prototype = {
        dialogOpened : false,
        targetElementId: null,

        initialize: function(targetElementId) {
            this.targetElementId = targetElementId;
        },

        openDialog: function(widgetUrl) {
            if (this.dialogOpened) {
                return
            }
            var oThis = this;
            widgetUrl = widgetUrl + 'widget_values/' + encodeURIComponent($(this.targetElementId).value);
            this.dialogWindow = jQuery('<div/>').modal({
                title: jQuery.mage.__('SubWidget configuration...'),
                type: 'slide',
                buttons: [],
                opened: function () {
                    var dialog = jQuery(this).addClass('loading magento-message')
                    new Ajax.Updater($(this), widgetUrl, {
                        evalScripts: true,
                        onComplete: function () {
                            dialog.removeClass('loading');
                        }
                    });
                },
                closed: function (e, modal) {
                    modal.modal.remove();
                    oThis.dialogOpened = false;
                }
            });
            this.dialogOpened = true;
            this.dialogWindow.modal('openModal');
        },

        closeDialog: function() {
            this.dialogWindow.modal('closeModal');
        }
    }

    SubWidget.FormHandler = Class.create();
    SubWidget.FormHandler.prototype = {
        widgetTargetId: null,
        dialogHandler: null,

        initialize: function(widgetTargetId) {
            this.widgetTargetId = widgetTargetId;
            this.formEl = widgetTargetId + '_options_form';
            this.dialogHandler =  window['subWidgetDialogHandler' + widgetTargetId];
        },

        insertWidget: function() {
            jQuery('#' + this.formEl).validate({
                ignore: ".skip-submit",
                errorClass: 'mage-error'
            });

            var validationResult = jQuery('#' + this.formEl).valid();
            if (validationResult) {
                var formElements = [];
                var i = 0;
                Form.getElements($(this.formEl)).each(function(e) {
                    if(!e.hasClassName('skip-submit')) {
                        formElements[i] = e;
                        i++;
                    }
                });

                var params = Form.serializeElements(formElements);

                new Ajax.Request($(this.formEl).action,
                    {
                        parameters: params,
                        onComplete: function(transport) {
                            try {
                                this.dialogHandler.closeDialog();
                                $(this.widgetTargetId).value = transport.responseText;
                            } catch(e) {
                                alert({
                                    content: e.message
                                });
                            }
                        }.bind(this)
                    });
            }
        }
    }

    window.SubWidget = SubWidget;
});