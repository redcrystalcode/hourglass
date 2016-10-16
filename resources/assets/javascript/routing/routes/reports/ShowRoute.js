import BaseRoute from 'routing/routes/BaseRoute';
import ReportModel from 'models/ReportModel';
import ReportDetailView from 'views/reports/detail/ReportDetailView';
import ApplicationService from 'services/ApplicationService';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const ShowRoute = BaseRoute.extend({
    fetch() {
        this.model = new ReportModel({
            id: this.options.reportId
        });
        return this.model.fetch();
    },

    render() {
        ApplicationService.request('sidebar:hide');
        this.container.show(new ReportDetailView({
            model: this.model
        }));
    }
});

export default ShowRoute;
