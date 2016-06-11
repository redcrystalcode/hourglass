import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import ApplicationService from 'services/ApplicationService';
import IndexRoute from 'routing/routes/employees/IndexRoute';

const EmployeesRouter = BaseRouter.extend({
    onInitialize() {
        HeaderService.request('add', {
            icon: 'people',
            name: 'Employees',
            path: 'employees',
            type: 'primary'
        });
    },

    routes: {
        employees: 'employees',
    },

    employees() {
        HeaderService.request('activate', 'employees');
        ApplicationService.request('sidebar:hide');
        return new IndexRoute({
            container: this.container
        });
    }
});

export default EmployeesRouter;
