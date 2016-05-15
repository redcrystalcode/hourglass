import BaseRoute from 'routing/routes/BaseRoute';
import AcceptInvitationView from 'views/auth/AcceptInvitationView';
// import AccountModel from 'models/AccountModel';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const AcceptInvitationRoute = BaseRoute.extend({
    fetch() {
        // this.model = new AccountModel();
        // return this.model.fetch();
    },
    render() {
        this.container.show(new AcceptInvitationView({
            invitation: this.options.invitation
        }));
    }
});

export default AcceptInvitationRoute;
