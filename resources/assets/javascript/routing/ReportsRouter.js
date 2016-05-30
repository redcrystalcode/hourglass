import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import ApplicationService from 'services/ApplicationService';
import IndexRoute from 'routing/routes/reports/IndexRoute';
import ShowRoute from 'routing/routes/reports/ShowRoute';

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
        'reports': 'reports',
        'reports/:id': 'showReport',
    },

    reports() {
        HeaderService.request('activate', 'reports');
        ApplicationService.request('sidebar:hide');
        return new IndexRoute({
            container: this.container
        });
    },

    showReport(id) {
        HeaderService.request('activate', 'reports.detail');
        ApplicationService.request('sidebar:hide');
        return new ShowRoute({
            container: this.container,
            reportId: id,
        });
    }
});

export default ReportsRouter;
