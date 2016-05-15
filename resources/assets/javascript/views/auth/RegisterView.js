import api from 'core/Api';
import ApplicationService from 'services/ApplicationService';
import FormValidator from 'components/FormValidator';
import {ItemView} from 'backbone.marionette';
import template from 'templates/auth/register.tpl';
import {getFormData} from 'helpers';

const RegisterView = ItemView.extend({
    template,

    ui: {
        error: '#error',
        form: 'form'
    },

    events: {
        'submit @ui.form': 'handleRegistration'
    },

    onShow() {
        this.validator = new FormValidator({
            form: this.ui.form
        });
        this.ui.form.find('input').first().focus();
    },

    handleRegistration(e) {
        e.preventDefault();
        var data = getFormData(this.ui.form);
        api.register(data)
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

export default RegisterView;
