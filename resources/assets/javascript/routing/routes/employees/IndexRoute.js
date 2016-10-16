import BaseRoute from 'routing/routes/BaseRoute';
import PageableEmployeesCollection from 'collections/PageableEmployeesCollection';
import PageableAgenciesCollection from 'collections/PageableAgenciesCollection';
import EmployeesLayoutView from 'views/employees/EmployeesLayoutView';
import ApplicationService from 'services/ApplicationService';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    fetch() {
        this.employees = new PageableEmployeesCollection([], {
            queryParams: {
                include_deleted: true,
            }
        });
        this.groups = new PageableAgenciesCollection();
        return Promise.all([
            this.employees.fetch(),
            this.groups.fetch(),
        ]);
    },
    render() {
        ApplicationService.request('sidebar:hide');
        this.container.show(new EmployeesLayoutView({
            employees: this.employees,
            groups: this.groups,
        }));
    }
});

export default IndexRoute;
