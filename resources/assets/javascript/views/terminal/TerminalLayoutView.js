import {LayoutView} from 'backbone.marionette';
import TerminalClockView from 'views/terminal/TerminalClockView';
import template from 'templates/terminal/layout.tpl';

const TerminalLayoutView = LayoutView.extend({
    template,

    regions: {
        clock: '.clock-region',
        prompt: '.prompt-region',
        shifts: '.shifts-region'
    },

    onBeforeShow() {
        this.showChildView('clock', new TerminalClockView());
        this.showChildView('prompt', this.options.prompt);
    },
});

export default TerminalLayoutView;
