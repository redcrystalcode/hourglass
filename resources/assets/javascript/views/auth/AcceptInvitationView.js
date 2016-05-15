import api from 'core/Api';
import ApplicationService from 'services/ApplicationService';
import FormValidator from 'components/FormValidator';
import {ItemView} from 'backbone.marionette';
import template from 'templates/auth/accept-invitation.tpl';
import {getFormData} from 'helpers';

const AcceptInvitationView = ItemView.extend({
    template,

    ui: {
        form: 'form'
    },

    events: {
        'submit @ui.form': 'handleFormSubmit'
    },

    onShow() {
        this.validator = new FormValidator({
            form: this.ui.form
        });
        this.ui.form.find('input').first().focus();
    },

    handleFormSubmit(e) {
        e.preventDefault();
        var data = getFormData(this.ui.form);
        data.code = this.options.invitation.code;
        var endpoint = 'invitations/' + this.options.invitation.id + '/accept';
        api.authorize(endpoint, data)
            .then(this.redirect)
            .catch(this.showErrors.bind(this));
    },

    redirect() {
        return ApplicationService.request('route', '');
    },

    showErrors(errors) {
        this.validator.showServerErrors(errors);
    }
});

export default AcceptInvitationView;
