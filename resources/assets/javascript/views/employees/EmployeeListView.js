import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import EmployeeItemView from 'views/employees/EmployeeItemView';
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

    onBeforeShow() {
        this.showChildView('employees', new CollectionCard({
            collection: this.collection,
            childView: EmployeeItemView,
            emptyView: EmptyView.extend({
                icon: 'work',
                heading: "There's nothing here.",
                subhead: 'Looks like there are no employees here. Try adding one!'
            })
        }));
    },

    showAddEmployeeActionSheet() {
        let sheet = new ActionSheet({
            view: new ManageEmployeeView({collection: this.collection})
        });
        sheet.open();
    }
});

export default EmployeeListView;
