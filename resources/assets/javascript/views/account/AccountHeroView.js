import {ItemView} from 'backbone.marionette';
import template from 'templates/account/hero.tpl';

const AccountHeroView = ItemView.extend({
    template,

    modelEvents: {
        sync: 'render'
    },
});

export default AccountHeroView;
