import {ItemView} from 'backbone.marionette';
import nprogress from 'nprogress';
import Radio from 'backbone.radio';
import api from 'core/Api';
import EmployeeModel from 'models/EmployeeModel';
import FormValidator from 'components/FormValidator';
import TerminalService from 'services/TerminalService';
import NotificationService from 'services/NotificationService';
import Confirm from 'components/Confirm';
import moment from 'moment';
import {time} from 'helpers';
import template from 'templates/terminal/prompts/clock-in-or-out.tpl';
import mdl from 'mdl';

const Status = {
    PAUSED: 'paused',
    CLOCKED_IN: 'clocked_in',
    CLOCKED_OUT: 'clocked_out',
    CONFIRM_CLOCK_OUT: 'confirm_clock_out',
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
        'click .js-express-clock-in': 'expressClockIn',
        'submit @ui.form': 'onFormSubmit'
    },

    channel: Radio.channel('terminal'),

    registerTimecard() {
        TerminalService.request('register:timecard');
    },

    expressClockIn() {
        TerminalService.request('express:job');
    },

    onShow() {
        mdl.upgradeAllRegistered();
        this.validator = new FormValidator({
            form: this.ui.form
        });
        this.ui.input.focus();
    },

    onFormSubmit(e) {
        e && e.preventDefault();

        nprogress.start();
        let timecard = this.ui.input.val();
        this.clockInOrOut({terminal_key: timecard});
    },

    clockInOrOut(data) {
        return api.post('terminal/clock', null, data)
            .then(this.handleResponse.bind(this))
            .catch(this.handleErrors.bind(this));
    },

    handleResponse(response) {
        nprogress.done();

        // Clear the input for the next use.
        this.ui.input.val('');

        // Fix MDL Textfield bug where label stays as if input exists.
        this.ui.input.parent()[0].MaterialTextfield.checkDirty();

        if (response.status === Status.CLOCKED_OUT) {
            this.channel.trigger('clock:out', response.data);
            NotificationService.request('notify:clock:out', response.data);
        } else if (response.status === Status.CLOCKED_IN) {
            this.channel.trigger('clock:in', response.data);
            NotificationService.request('notify:clock:in', response.data);
        } else if (response.status === Status.CONFIRM_CLOCK_OUT) {
            Confirm.confirm({
                title: 'Clock out already?',
                body: "You just clocked in " + moment.utc(response.data.time_in).local().fromNow() + ". Are you sure you want to clock out already?",
                primaryAction: 'Clock Out',
            }).then(() => {
                this.clockInOrOut({terminal_key: response.data.terminal_key, clock_out_confirmed: true});
            });
        } else {
            TerminalService.request('select:job', new EmployeeModel(response.data));
        }
    },

    handleErrors(errors) {
        console.log(errors);
        this.validator.showServerErrors(errors);
        nprogress.done();
    }
});

export default ClockInOrOutPromptView;
