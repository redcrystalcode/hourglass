import nprogress from 'nprogress';
import {Collection} from 'backbone';
import Service from 'backbone.service';
import api from 'core/Api';
import TerminalLayoutView from 'views/terminal/TerminalLayoutView';
import ClockInOrOutPromptView from 'views/terminal/ClockInOrOutPromptView';
import RegisterTimecardPromptView from 'views/terminal/RegisterTimecardPromptView';
import SelectJobPromptView from 'views/terminal/SelectJobPromptView';

const TerminalService = Service.extend({
    setup(options = {}) {
        this.container = options.container;
    },

    requests: {
        'index': 'index',
        'register:timecard': 'registerTimecard',
        'select:job': 'selectJob'
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

    _show(view) {
        if (!this.layout || !this._isShowingView(TerminalLayoutView)) {
            this.layout = new TerminalLayoutView({
                prompt: view
            });
            this.container.show(this.layout);
            return;
        }

        this.layout.showChildView('prompt', view);
    },

    /**
     * Determine if the current container is showing a particular type of view.
     *
     * @param {object} viewType
     * @return {boolean}
     */
    _isShowingView(viewType) {
        return (this.container && this.container.currentView instanceof viewType);
    },
});

export default new TerminalService();
