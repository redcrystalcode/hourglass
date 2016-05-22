import Service from 'backbone.service';
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
        this._show(new RegisterTimecardPromptView());
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
