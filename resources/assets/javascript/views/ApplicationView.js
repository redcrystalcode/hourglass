import {LayoutView} from 'backbone.marionette';
import FooterView from 'views/FooterView';
import LoadingView from 'components/LoadingView';
import OnTheClockSidebarView from 'views/OnTheClockSidebarView';
import template from 'templates/application.tpl';
import mdl from 'mdl';

const ApplicationView = LayoutView.extend({
    template,
    el: '.app',

    regions: {
        header: '.app__header-region',
        content: '.app__content-region',
        footer: '.app__footer-region',
        sidebar: '.app__sidebar-region',
    },

    initialize() {
        this.content.on('show', this.upgradeMdlComponents);
        this.header.on('show', this.upgradeMdlComponents);
        this.footer.on('show', this.upgradeMdlComponents);
        this.sidebar.on('show', this.upgradeMdlComponents);
    },

    onRender() {
        this.showChildView('content', new LoadingView());
        this.showChildView('footer', new FooterView());
        this.showChildView('sidebar', new OnTheClockSidebarView());
    },

    upgradeMdlComponents() {
        mdl.upgradeAllRegistered();
    }
});

export default ApplicationView;