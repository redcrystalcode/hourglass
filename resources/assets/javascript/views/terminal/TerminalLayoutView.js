import {LayoutView} from 'backbone.marionette';
import TerminalClockView from 'views/terminal/TerminalClockView';
// import AccountHeroView from 'views/account/AccountHeroView';
// import AccountDetailsView from 'views/account/AccountDetailsView';
// import AccountMembersView from 'views/account/AccountMembersView';
import template from 'templates/terminal/layout.tpl';

const TerminalLayoutView = LayoutView.extend({
    template,

    regions: {
        clock: '.clock-region',
        prompt: '.prompt-region',
    },

    onBeforeShow() {
        this.showChildView('clock', new TerminalClockView());
        this.showChildView('prompt', this.options.prompt);
    },
});

export default TerminalLayoutView;
