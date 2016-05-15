import api from 'core/Api';
import ApplicationService from 'services/ApplicationService';
import FormValidator from 'components/FormValidator';
import {ItemView} from 'backbone.marionette';
import template from 'templates/auth/login.tpl';

const LoginView = ItemView.extend({
    template,

    ui: {
        error: '#error',
        form: 'form',
        email: '#email',
        password: '#password'
    },

    events: {
        'submit @ui.form': 'handleLoginSubmit',
    },

    onShow() {
        this.validator = new FormValidator({
            form: this.ui.form
        });
        this.ui.email.focus();
    },

    handleLoginSubmit(e) {
        e.preventDefault();
        var email = this.ui.email.val();
        var password = this.ui.password.val();
        api.login(email, password)
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

export default LoginView;
