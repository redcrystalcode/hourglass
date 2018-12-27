import BaseRoute from 'routing/routes/BaseRoute';
import TimesheetsLayoutView from 'views/timesheets/TimesheetsLayoutView';
import ApplicationService from 'services/ApplicationService';
import PageableTimesheetsCollection from 'collections/PageableTimesheetsCollection';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    fetch() {
        this.timesheets = PageableTimesheetsCollection.fromQueryParameters(this.options.query);
        return this.timesheets.setPageSize(25);
    },
    render() {
        ApplicationService.request('sidebar:hide');
        this.container.show(new TimesheetsLayoutView({
            timesheets: this.timesheets,
        }));
    }
});

export default IndexRoute;
