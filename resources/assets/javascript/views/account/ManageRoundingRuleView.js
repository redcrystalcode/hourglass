import {ItemView} from 'backbone.marionette';
import FormManager from 'components/FormManager';
import RoundingRuleModel from 'models/RoundingRuleModel';
import template from 'templates/account/rounding-rule-edit.tpl';

const ManageRoundingRuleView = ItemView.extend({
    template,
    actionSheetOptions() {
        var model = this.model;
        return {
            title: model.isNew() ? 'New Rounding Rule' : 'Edit Rounding Rule',
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
    templateHelpers() {
        let model = this.model;
        return {
            start: model.formatTime('start'),
            end: model.formatTime('end'),
            resolution: model.formatTime('resolution'),
        };
    },
    initialize(options) {
        this.model = options.model || new RoundingRuleModel();
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
        if (this.options.collection) {
            this.options.collection.add(this.model);
        }
        this.close();
    },
    close() {
        this.actionSheet.close();
    }
});

export default ManageRoundingRuleView;
