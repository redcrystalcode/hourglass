import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
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

    employees(query) {
        HeaderService.request('activate', 'employees');
        return new IndexRoute({
            query,
            container: this.container,
        });
    }
});

export default EmployeesRouter;
