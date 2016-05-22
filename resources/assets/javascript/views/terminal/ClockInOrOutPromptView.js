import {ItemView} from 'backbone.marionette';
import nprogress from 'nprogress';
import Radio from 'backbone.radio';
import api from 'core/Api';
import EmployeeModel from 'models/EmployeeModel';
import FormValidator from 'components/FormValidator';
import TerminalService from 'services/TerminalService';
import template from 'templates/terminal/prompts/clock-in-or-out.tpl';
import mdl from 'mdl';

const Status = {
    CLOCKED_IN: 'clocked_in',
    CLOCKED_OUT: 'clocked_out',
    SELECT_JOB: 'select_job',
};
const ClockInOrOutPromptView = ItemView.extend({
    template,

    ui: {
        input: 'input[name=terminal_key]',
        form: 'form',
    },

    events: {
        'click .js-register-timecard': 'registerTimecard',
        'submit @ui.form': 'onFormSubmit'
    },

    channel: Radio.channel('terminal'),

    registerTimecard() {
        TerminalService.request('register:timecard');
    },

    onShow() {
        mdl.upgradeAllRegistered();
        this.validator = new FormValidator({
            form: this.ui.form
        });
        this.ui.input.focus();
    },

    onFormSubmit(e) {
        e.preventDefault();
        nprogress.start();
        let timecard = this.ui.input.val();
        api.post('terminal/clock', null, {terminal_key: timecard, job_id: 2})
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

        // Clear the input for the next use.
        this.ui.input.val('');

        // Fix MDL Textfield bug where label stays as if input exists.
        this.ui.input.parent()[0].MaterialTextfield.checkDirty();

        // If clocked out:
        if (response.status === Status.CLOCKED_OUT) {
            this.channel.trigger('clock:out', response.data.id);
        } else if (response.status === Status.CLOCKED_IN) {
            this.channel.trigger('clock:in', response.data);
        } else {
            // Must select job.
            console.log('Select a Job!');
        }
    },
});

export default ClockInOrOutPromptView;
