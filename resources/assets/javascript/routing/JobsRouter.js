import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
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
        jobs: 'jobs',
    },

    jobs() {
        HeaderService.request('activate', 'jobs');
        return new IndexRoute({
            container: this.container
        });
    }
});

export default JobsRouter;
