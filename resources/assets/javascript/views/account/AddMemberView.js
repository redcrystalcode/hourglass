import {ItemView} from 'backbone.marionette';
// import InvitationModel from 'models/InvitationModel';
import FormManager from 'components/FormManager';
import AddsModelLoadingStateToActionSheet from 'views/mixins/AddsModelLoadingStateToActionSheet';
import {mixin} from 'helpers';
import template from 'templates/account/add-member.tpl';

const AddMemberView = ItemView.extend({
    template,
    actionSheetOptions: {
        title: 'Invite a Member',
        primaryAction: {
            label: 'Invite',
            action: 'save'
        },
        secondaryAction: {
            label: 'Cancel',
            action: 'close'
        }
    },
    initialize() {
        this.model = new InvitationModel();
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

mixin(AddMemberView, AddsModelLoadingStateToActionSheet);

export default AddMemberView;
