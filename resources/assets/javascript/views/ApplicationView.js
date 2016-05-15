import {LayoutView} from 'backbone.marionette';
import FooterView from 'Views/FooterView';
import LoadingView from 'components/LoadingView';
import template from 'templates/application.tpl';
import mdl from 'mdl';

const ApplicationView = LayoutView.extend({
    template,
    el: '.app',

    regions: {
        header: '.app__header-region',
        content: '.app__content-region',
        footer: '.app__footer-region',
    },

    initialize() {
        this.content.on('show', this.upgradeMdlComponents);
        this.header.on('show', this.upgradeMdlComponents);
        this.footer.on('show', this.upgradeMdlComponents);
    },

    onRender() {
        this.showChildView('content', new LoadingView());
        this.showChildView('footer', new FooterView());
    },

    upgradeMdlComponents() {
        mdl.upgradeAllRegistered();
    }
});

export default ApplicationView;
