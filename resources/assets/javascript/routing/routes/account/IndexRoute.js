import BaseRoute from 'routing/routes/BaseRoute';
import AccountModel from 'models/AccountModel';
import AccountLayoutView from 'views/account/AccountLayoutView';
import ApplicationService from 'services/ApplicationService';
import RoundingRulesCollection from 'collections/RoundingRulesCollection';
// import RoundingRulesCollection from 'collections/RoundingRulesCollection';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    fetch() {
        this.model = new AccountModel();
        this.roundingRulesCollection = new RoundingRulesCollection();
        return Promise.all([
            this.model.fetch(),
            this.roundingRulesCollection.fetch(),
        ]);
    },
    render() {
        ApplicationService.request('sidebar:hide');
        this.container.show(new AccountLayoutView({
            model: this.model,
            roundingRulesCollection: this.roundingRulesCollection,
        }));
    }
});

export default IndexRoute;
