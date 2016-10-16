import {ItemView} from 'backbone.marionette';
import GroupModel from 'models/GroupModel';
import FormManager from 'components/FormManager';
import AddsModelLoadingStateToActionSheet from 'views/mixins/AddsModelLoadingStateToActionSheet';
import {mixin} from 'helpers';
import template from 'templates/employees/groups/edit.tpl';

const EditGroupView = ItemView.extend({
    template,
    actionSheetOptions() {
        let model = this.model;
        return {
            title: model.isNew() ? 'Add a Group' : 'Edit Group',
            primaryAction: {
                label: model.isNew() ? 'Create' : 'Save',
                action: 'save'
            },
            secondaryAction: {
                label: 'Cancel',
                action: 'close'
            }
        };
    },
    initialize(options) {
        this.model = options.model || new GroupModel();
    },
    onShow() {
        this.formManager = new FormManager({
            form: this.$el.find('form'),
            model: this.model
        });
        this.listenTo(this.formManager, 'save:success', this.onSaveSuccess);
    },
    onSaveSuccess() {
        this.collection.fetch();
        this.close();
    },
    save() {
        this.formManager.submit();
    },
    close() {
        this.actionSheet.close();
    },
});

mixin(EditGroupView, AddsModelLoadingStateToActionSheet);

export default EditGroupView;
