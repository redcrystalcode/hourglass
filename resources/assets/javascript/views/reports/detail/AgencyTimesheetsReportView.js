import {Collection} from 'backbone';
import {CompositeView} from 'backbone.marionette';
import moment from 'moment';
import EmployeeTimesheetReportView from 'views/reports/detail/EmployeeTimesheetReportView';
import template from 'templates/reports/detail/agency/report.tpl';

const AgencyTimesheetsReportView = CompositeView.extend({
    template,
    childView: EmployeeTimesheetReportView,
    childViewOptions: {
        hideMetaHeader: true,
    },
    childViewContainer: '.reports-container',
    templateHelpers() {
        return {
            start: moment(this.model.get('start')).format('M/DD/YY'),
            end: moment(this.model.get('end')).format('M/DD/YY'),
            count: this.model.get('employees').length
        };
    },
    initialize() {
        this.collection = new Collection(this.model.get('employees'));
    },
});

export default AgencyTimesheetsReportView;
