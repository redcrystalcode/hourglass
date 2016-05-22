import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import ApplicationService from 'services/ApplicationService';
import IndexRoute from 'routing/routes/jobs/IndexRoute';

const JobsRouter = BaseRouter.extend({
    onInitialize() {
        HeaderService.request('add', {
            icon: 'work',
            name: 'Jobs',
            path: 'jobs',
            type: 'primary'
        });
    },

    routes: {
        jobs: 'jobs'
    },

    jobs() {
        HeaderService.request('activate', 'jobs');
        ApplicationService.request('sidebar:hide');
        return new IndexRoute({
            container: this.container
        });
    }
});

export default JobsRouter;
