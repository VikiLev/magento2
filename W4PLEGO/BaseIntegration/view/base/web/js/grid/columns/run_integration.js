'use strict';
define([
    'Magento_Ui/js/grid/columns/column',
    'jquery',
    'mage/template',
    'text!W4PLEGO_BaseIntegration/templates/grid/cells/integration.html',
    'mage/backend/notification',
    'Magento_Ui/js/modal/modal',
    "prototype"
], function (Column, $, mageTemplate, sendmailPreviewTemplate, notification) {
    'use strict';

    return Column.extend({

        integrationRunView: function () {
            return {
                modal: null,
                open: function (row) {
                    let viewUrl = row.view_url;
                    let elementId = row.id;
                    if (viewUrl && elementId) {
                        $.ajax({
                            url: viewUrl,
                            data: {
                                id: elementId
                            },
                            showLoader: true,
                            dataType: 'html',
                            success: function (data, textStatus, transport) {
                                this.openDialogWindow(data, elementId, row);
                            }.bind(this)
                        });
                    }
                },
                openDialogWindow: function (data, elementId, row) {
                    var self = this;
                    if (this.modal) {
                        this.modal.html($(data).html());
                    } else {
                        this.modal = $(data).modal({
                            title: $.mage.__('Process') + ':' + row.process_code,
                            modalClass: 'magento',
                            type: 'slide',
                            firedElementId: elementId,
                            buttons: [
                                {
                                    text: $.mage.__('Close'),
                                    class: 'action- scalable back',
                                    click: function () {
                                        self.closeDialogWindow(this);
                                    }
                                }],
                            close: function () {
                                self.closeDialogWindow(this);
                            }
                        });
                    }
                    this.modal.modal('openModal');
                },
                closeDialogWindow: function (dialogWindow) {
                    $('body').trigger('processStop');
                    dialogWindow.closeModal();
                }
            };
        },
        getTitle: function (row) {
        },
        preview: function (row) {
            this.integrationRunView().open(row);
        },
        buttonPreview: function (row) {
        },
        getFieldHandler: function (row) {
            return this.preview.bind(this, row);
        }
    });

});
