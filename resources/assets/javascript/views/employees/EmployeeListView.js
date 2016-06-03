import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import EmployeeItemView from 'views/employees/EmployeeItemView';
import PageableEmployeesCollection from 'collections/PageableEmployeesCollection';
import ManageEmployeeView from 'views/employees/ManageEmployeeView';
import template from 'templates/employees/list.tpl';

const EmployeeListView = LayoutView.extend({
    template,

    regions: {
        employees: '.employees-region'
    },

    events: {
        'click .js-add-employee-button': 'showAddEmployeeActionSheet',
    },

    initialize() {
        this.employees = new PageableEmployeesCollection([], {
            queryParams: {
                include_deleted: true,
            }
        });
    },

    onBeforeShow() {
        this.showChildView('employees', new CollectionCard({
            collection: this.employees,
            childView: EmployeeItemView,
            emptyView: EmptyView.extend({
                icon: 'work',
                heading: "There's nothing here.",
                subhead: 'Looks like there are no employees here. Try adding one!'
            })
        }));
        this.employees.fetch();
    },

    showAddEmployeeActionSheet() {
        var sheet = new ActionSheet({
            view: new ManageEmployeeView({collection: this.employees})
        });
        sheet.open();
    }
});

export default EmployeeListView;
