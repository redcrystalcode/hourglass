import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import ApplicationService from 'services/ApplicationService';
import IndexRoute from 'routing/routes/reports/IndexRoute';

const ReportsRouter = BaseRouter.extend({
    onInitialize() {
        HeaderService.request('add', {
            icon: 'assessment',
            name: 'Reports',
            path: 'reports',
            type: 'primary'
        });
    },

    routes: {
        reports: 'reports',
    },

    reports() {
        HeaderService.request('activate', 'reports');
        ApplicationService.request('sidebar:hide');
        return new IndexRoute({
            container: this.container
        });
    }
});

export default ReportsRouter;
