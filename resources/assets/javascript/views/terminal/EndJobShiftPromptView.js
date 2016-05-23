import {ItemView} from 'backbone.marionette';
import nprogress from 'nprogress';
import Radio from 'backbone.radio';
import api from 'core/Api';
import FormValidator from 'components/FormValidator';
import TerminalService from 'services/TerminalService';
import NotificationService from 'services/NotificationService';
import template from 'templates/terminal/prompts/end-shift.tpl';
import {getFormData} from 'helpers';
import mdl from 'mdl';

const EndJobShiftPromptView = ItemView.extend({
    template,

    ui: {
        form: 'form',
    },

    events: {
        'click .js-cancel': 'cancel',
        'click .js-end': 'submit',
    },

    channel: Radio.channel('terminal'),

    cancel() {
        TerminalService.request('index');
    },

    onShow() {
        mdl.upgradeAllRegistered();
        this.validator = new FormValidator({
            form: this.ui.form
        });
        this.ui.form.find('input').first().focus();
    },

    submit() {
        console.log('Submitted');
        let data = getFormData(this.ui.form);
        console.log(data);
        nprogress.start();
        api.post('terminal/shifts/%s/end', this.model.get('id'), data)
            .then(this.handleResponse.bind(this))
            .catch((errors) => {
                console.log(errors);
                this.validator.showServerErrors(errors);
                nprogress.done();
            });
    },

    handleResponse(response) {
        nprogress.done();
        console.log(response);

        NotificationService.request('notify', {
            icon: 'assignment_turned_in',
            primary: 'Shift ended.',
            secondary: `#${this.model.get('job').number} - ${this.model.get('job').name}`
        });
        this.model.collection.remove(this.model);
        TerminalService.request('index');
    },
});

export default EndJobShiftPromptView;
