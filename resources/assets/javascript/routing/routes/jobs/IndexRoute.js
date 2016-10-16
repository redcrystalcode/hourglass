import BaseRoute from 'routing/routes/BaseRoute';
import JobsLayoutView from 'views/jobs/JobsLayoutView';
import ApplicationService from 'services/ApplicationService';
import PageableJobsCollection from 'collections/PageableJobsCollection';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    fetch() {
        this.jobs = PageableJobsCollection.fromQueryParameters(this.options.query, {
            queryParams: {
                include_deleted: true,
            }
        });
        return this.jobs.fetch();
    },
    render() {
        ApplicationService.request('sidebar:hide');
        this.container.show(new JobsLayoutView({
            jobs: this.jobs,
        }));
    }
});

export default IndexRoute;
