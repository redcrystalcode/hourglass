import {LayoutView} from 'backbone.marionette';
import ActionSheet from 'components/ActionSheet';
import EditAccountDetailsView from 'views/account/EditAccountDetailsView';
import template from 'templates/account/details.tpl';

const AccountDetailsView = LayoutView.extend({
    template,

    events: {
        'click .js-edit-details': 'showEditDetailsActionSheet'
    },

    modelEvents: {
        sync: 'render'
    },

    showEditDetailsActionSheet() {
        let sheet = new ActionSheet({
            view: new EditAccountDetailsView({model: this.model})
        });
        sheet.open();
    }
});

export default AccountDetailsView;
