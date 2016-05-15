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
    //     loading: '.account-loading-region',
    //     hero: '.account-hero-region',
    //     details: '.account-details-region',
    //     members: '.account-members-region',
    },

    onBeforeShow() {
        this.showChildView('clock', new TerminalClockView());
        // this.showChildView('details', new AccountDetailsView({
        //     model: this.model
        // }));
        // this.showChildView('members', new AccountMembersView({
        //     model: this.model
        // }));
    },
});

export default TerminalLayoutView;
