import nprogress from "nprogress";
import {Collection} from "backbone";
import Service from "backbone.service";
import api from "core/Api";
import TerminalLayoutView from "views/terminal/TerminalLayoutView";
import ClockInOrOutPromptView from "views/terminal/ClockInOrOutPromptView";
import RegisterTimecardPromptView from "views/terminal/RegisterTimecardPromptView";
import SelectJobPromptView from "views/terminal/SelectJobPromptView";
import ExpressSelectJobPromptView from "views/terminal/ExpressSelectJobPromptView";
import ExpressClockInPromptView from "views/terminal/ExpressClockInPromptView";
import OngoingShiftsView from 'views/terminal/OngoingShiftsView';
import EndJobShiftPromptView from 'views/terminal/EndJobShiftPromptView';

const TerminalService = Service.extend({
    setup(options = {}) {
        this.container = options.container;
    },

    requests: {
        'index': 'index',
        'register:timecard': 'registerTimecard',
        'select:job': 'selectJob',
        'express:job': 'expressClockInJobSelector',
        'express:clock': 'expressClockIn',
        'end:shift': 'endShift',
    },

    index() {
        this._show(new ClockInOrOutPromptView());
    },

    registerTimecard() {
        nprogress.start();
        api.get('terminal/timecards').then((response) => {
            nprogress.done();
            this._show(new RegisterTimecardPromptView({
                timecards: new Collection(response.data),
            }));
        }).catch((errors) => {
            nprogress.done();
            // TODO - Error Handling
            console.error('Something went wrong!');
            console.error(errors);
        });
    },

    selectJob(employee) {
        this._show(new SelectJobPromptView({
            model: employee,
        }));
    },

    endShift(shift) {
        this._show(new EndJobShiftPromptView({
            model: shift,
        }));
    },

    expressClockInJobSelector() {
        this._show(new ExpressSelectJobPromptView());
    },

    expressClockIn(job) {
        this._show(new ExpressClockInPromptView({job}));
    },

    _show(view) {
        if (!this.layout || !this._isShowingView(TerminalLayoutView)) {
            this.layout = new TerminalLayoutView({
                prompt: view
            });
            this.container.show(this.layout);
        } else {
            this.layout.showChildView('prompt', view);
        }

        if (view instanceof ClockInOrOutPromptView) {
            if (this._isShowingView(OngoingShiftsView, this.layout.shifts)) {
                this.layout.shifts.$el.show();
            } else {
                this.layout.showChildView('shifts', new OngoingShiftsView());
            }
        } else {
            this.layout.shifts.$el.hide();
        }
    },

    /**
     * Determine if the current container is showing a particular type of view.
     *
     * @param {object} viewType
     * @param {object} container
     * @return {boolean}
     */
    _isShowingView(viewType, container = this.container) {
        return (container && container.currentView instanceof viewType);
    },
});

export default new TerminalService();
