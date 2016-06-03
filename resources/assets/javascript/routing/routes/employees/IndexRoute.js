import BaseRoute from 'routing/routes/BaseRoute';
import EmployeesLayoutView from 'views/employees/EmployeesLayoutView';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    render() {
        this.container.show(new EmployeesLayoutView());
    }
});

export default IndexRoute;
