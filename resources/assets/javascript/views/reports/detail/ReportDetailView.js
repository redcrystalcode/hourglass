import {LayoutView} from 'backbone.marionette';
import EmployeeTimesheetReportView from 'views/reports/detail/EmployeeTimesheetReportView';
import JobShiftReportView from 'views/reports/detail/JobShiftReportView';
import template from 'templates/reports/detail/layout.tpl';

const ViewMap = {
    timesheet: EmployeeTimesheetReportView,
    shift: JobShiftReportView,
    // job: JobSummaryReportView,
};
const ReportDetailView = LayoutView.extend({
    template,
    regions: {
        reportRegion: '.report-region',
    },
    onBeforeShow() {
        var View = ViewMap[this.model.get('type')];
        this.showChildView('reportRegion', new View({
            model: this.model
        }));
    },
});

export default ReportDetailView;
