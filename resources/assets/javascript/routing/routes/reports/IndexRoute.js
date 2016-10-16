import BaseRoute from 'routing/routes/BaseRoute';
import ReportsLayoutView from 'views/reports/ReportsLayoutView';
import ApplicationService from 'services/ApplicationService';
import PageableReportsCollection from 'collections/PageableReportsCollection';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    fetch() {
        this.reports = new PageableReportsCollection();
        return this.reports.fetch();
    },
    render() {
        ApplicationService.request('sidebar:hide');
        this.container.show(new ReportsLayoutView({
            reports: this.reports,
        }));
    }
});

export default IndexRoute;
