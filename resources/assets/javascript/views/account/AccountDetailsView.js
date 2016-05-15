import {ItemView} from 'backbone.marionette';
import ActionSheet from 'components/ActionSheet';
import EditAccountDetailsView from 'views/account/EditAccountDetailsView';
import template from 'templates/account/details.tpl';

const AccountDetailsView = ItemView.extend({
    template,

    events: {
        'click .js-edit-details': 'showEditDetailsActionSheet'
    },

    modelEvents: {
        sync: 'render'
    },

    showEditDetailsActionSheet() {
        var sheet = new ActionSheet({
            view: new EditAccountDetailsView({model: this.model})
        });
        sheet.open();
    }
});

export default AccountDetailsView;
