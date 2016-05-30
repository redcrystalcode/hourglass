import $ from "jquery";
import {LayoutView} from "backbone.marionette";
import EmployeeTimesheetReportView from "views/reports/detail/EmployeeTimesheetReportView";
import JobShiftReportView from "views/reports/detail/JobShiftReportView";
import CreateReportView from "views/reports/CreateReportView";
import PrintReportView from "views/reports/detail/PrintReportView";
import ActionSheet from "components/ActionSheet";
import template from "templates/reports/detail/layout.tpl";

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
    events: {
        'click .js-new-report-button': 'showCreateReportActionSheet',
        'click .js-print-button': 'print',
    },
    onBeforeShow() {
        var View = ViewMap[this.model.get('type')];
        this.showChildView('reportRegion', new View({
            model: this.model
        }));
    },

    showCreateReportActionSheet() {
        var sheet = new ActionSheet({
            view: new CreateReportView(),
        });
        sheet.open();
    },

    print() {
        var printable = window.open(
            null,
            '_blank',
            'toolbar=no,scrollbars=no,resizable=no,width=1200,height=800'
        );

        var View = ViewMap[this.model.get('type')];
        var view = new PrintReportView({
            contentView: new View({model: this.model})
        });

        view.render().onBeforeShow();
        var printableDoc = printable.document.open();
        printableDoc.write(view.$el.html());
        printableDoc.close();
    },
});

export default ReportDetailView;
