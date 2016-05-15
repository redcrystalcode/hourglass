import {ItemView} from 'backbone.marionette';
// import ProjectModel from 'models/ProjectModel';
import FormManager from 'components/FormManager';
import AddsModelLoadingStateToActionSheet from 'views/mixins/AddsModelLoadingStateToActionSheet';
import {mixin} from 'helpers';
import template from 'templates/projects/edit-project.tpl';

const EditProjectView = ItemView.extend({
    template,
    actionSheetOptions() {
        return {
            title: this.model.isNew() ? 'New Project' : 'Edit Project',
            primaryAction: {
                label: 'Save',
                action: 'save'
            },
            secondaryAction: {
                label: 'Cancel',
                action: 'close'
            }
        };
    },
    templateHelpers() {
        return {
            is_new: this.model.isNew(),
        };
    },
    initialize() {
        this.model = this.model || new ProjectModel();
    },
    onShow() {
        this.formManager = new FormManager({
            form: this.$el.find('form'),
            model: this.model
        });
        this.listenTo(this.formManager, 'save:success', this.onSaveSuccess);
    },
    onSaveSuccess() {
        this.collection.fetch({reset: true});
        this.close();
    },
    save() {
        this.formManager.submit();
    },
    close() {
        this.actionSheet.close();
    },
});

mixin(EditProjectView, AddsModelLoadingStateToActionSheet);

export default EditProjectView;
