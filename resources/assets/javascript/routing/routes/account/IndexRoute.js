import BaseRoute from 'routing/routes/BaseRoute';
import AccountModel from 'models/AccountModel';
import AccountLayoutView from 'views/account/AccountLayoutView';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    fetch() {
        // this.model = new AccountModel();
        // return this.model.fetch();
    },
    render() {
        this.container.show(new AccountLayoutView({
            model: this.model,
        }));
    }
});

export default IndexRoute;
