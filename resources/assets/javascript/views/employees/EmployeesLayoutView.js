import {LayoutView} from 'backbone.marionette';
import EmployeeListView from 'views/employees/EmployeeListView';
import GroupsListView from 'views/employees/groups/GroupsListView';
import template from 'templates/employees/layout.tpl';

const EmployeesLayoutView = LayoutView.extend({
    template,

    regions: {
        employees: '.employee-list-region',
        groups: '.groups-list-region',
    },

    onBeforeShow() {
        this.showChildView('employees', new EmployeeListView({
            collection: this.options.employees,
        }));
        this.showChildView('groups', new GroupsListView({
            collection: this.options.groups,
        }));
    },
});

export default EmployeesLayoutView;
