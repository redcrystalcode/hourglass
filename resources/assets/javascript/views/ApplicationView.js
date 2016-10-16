import {LayoutView} from 'backbone.marionette';
import FooterView from 'views/FooterView';
import NotificationsView from 'views/NotificationsView';
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
        notifications: '.app__notifications-region',
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
        this.showChildView('footer', new FooterView());
        this.showChildView('notifications', new NotificationsView());
        this.showChildView('sidebar', new OnTheClockSidebarView());
    },

    upgradeMdlComponents() {
        mdl.upgradeAllRegistered();
    }
});

export default ApplicationView;
