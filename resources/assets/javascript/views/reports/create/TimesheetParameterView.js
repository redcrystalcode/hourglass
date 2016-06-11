import {LayoutView} from 'backbone.marionette';
import MiniChooser from 'components/MiniChooser';
import DatePicker from 'components/DatePicker';
import PageableEmployeesCollection from 'collections/PageableEmployeesCollection';
import SearchesCollection from 'views/mixins/SearchesCollection';
import {mixin} from 'helpers';
import mdl from 'mdl';
import template from 'templates/reports/parameters/timesheet.tpl';

/**
 * Form for creating a Timesheet Report
 */
const TimesheetParameterView = LayoutView.extend({
    template,
    regions: {
        employeeChooser: '.employee-chooser-region'
    },
    ui: {
        startDate: '.js-date-start',
        endDate: '.js-date-end',
    },
    onBeforeShow() {
        this.collection = new PageableEmployeesCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            itemIcon: 'person',
            collection: this.collection,
        });
        this.showChildView('employeeChooser', this.chooser);
        this.collection.fetch();
        this.listenTo(this.chooser, 'selected', this.onEmployeeSelected);
    },
    onShow() {
        mdl.upgradeAllRegistered();
        new DatePicker({field: this.ui.startDate});
        new DatePicker({field: this.ui.endDate});
    },
    onEmployeeSelected(employee) {
        this.model.set('employee_id', employee.get('id'));
    }
});
mixin(TimesheetParameterView, SearchesCollection);

export default TimesheetParameterView;
