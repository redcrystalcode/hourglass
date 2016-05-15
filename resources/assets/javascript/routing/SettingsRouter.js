import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
// import AccountLayoutView from 'views/settings/AccountLayoutView'

const SettingsRouter = BaseRouter.extend({
    onInitialize() {
        HeaderService.request('add', {
            icon: 'settings',
            name: 'Settings',
            path: 'settings',
            type: 'primary'
        });
    },

    routes: {
        settings: 'settings',
    },

    account() {
        HeaderService.request('activate', 'settings');
        // this.container.show(new AccountLayoutView());
    }
});

export default SettingsRouter;
