import {LayoutView} from 'backbone.marionette';
import AccountHeroView from 'views/account/AccountHeroView';
import AccountDetailsView from 'views/account/AccountDetailsView';
import RoundingRulesView from 'views/account/RoundingRulesView';
import template from 'templates/account/layout.tpl';

const AccountLayoutView = LayoutView.extend({
    template,

    regions: {
        loading: '.account-loading-region',
        hero: '.account-hero-region',
        details: '.account-details-region',
        rounding: '.rounding-rules-region',
    },

    onBeforeShow() {
        this.showChildView('hero', new AccountHeroView({
            model: this.model
        }));
        this.showChildView('details', new AccountDetailsView({
            model: this.model
        }));
        this.showChildView('rounding', new RoundingRulesView({
            collection: this.options.roundingRulesCollection
        }));
    },
});

export default AccountLayoutView;
