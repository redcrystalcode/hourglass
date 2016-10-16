import {LayoutView} from 'backbone.marionette';
import EmployeeListView from 'views/employees/EmployeeListView';
import template from 'templates/employees/layout.tpl';

const EmployeesLayoutView = LayoutView.extend({
    template,

    regions: {
        employees: '.employee-list-region',
    },

    onBeforeShow() {
        this.showChildView('employees', new EmployeeListView({
            collection: this.options.employees,
        }));
    },
});

export default EmployeesLayoutView;
