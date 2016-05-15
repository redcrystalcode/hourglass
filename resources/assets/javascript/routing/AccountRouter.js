import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import IndexRoute from 'routing/routes/account/IndexRoute';

const AccountRouter = BaseRouter.extend({
    onInitialize() {
        HeaderService.request('add', {
            icon: 'business',
            name: 'Account',
            path: 'account',
            type: 'primary'
        });
    },

    routes: {
        account: 'account',
    },

    account() {
        HeaderService.request('activate', 'account');
        return new IndexRoute({
            container: this.container
        });
    }
});

export default AccountRouter;
