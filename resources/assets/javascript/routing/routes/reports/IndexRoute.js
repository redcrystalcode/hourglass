import BaseRoute from 'routing/routes/BaseRoute';
import ReportsLayoutView from 'views/reports/ReportsLayoutView';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    render() {
        this.container.show(new ReportsLayoutView());
    }
});

export default IndexRoute;
