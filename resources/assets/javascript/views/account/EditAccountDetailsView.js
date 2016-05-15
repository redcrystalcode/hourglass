import {ItemView} from 'backbone.marionette';
import FormManager from 'components/FormManager';
import template from 'templates/account/edit.tpl';

const EditAccountDetailsView = ItemView.extend({
    template,
    actionSheetOptions: {
        title: 'Edit Account Details',
        primaryAction: {
            label: 'Save',
            action: 'save'
        },
        secondaryAction: {
            label: 'Cancel',
            action: 'close'
        }
    },
    onShow() {
        this.formManager = new FormManager({
            form: this.$el.find('form'),
            model: this.model
        });
        this.listenTo(this.formManager, 'save:success', this.onSaveSuccess);
    },
    save() {
        this.formManager.submit();
    },
    onSaveSuccess() {
        this.close();
    },
    close() {
        this.actionSheet.close();
    }
});

export default EditAccountDetailsView;
