import {Collection} from 'backbone';
import {CompositeView} from 'backbone.marionette';
import moment from 'moment';
import JobShiftReportView from 'views/reports/detail/JobShiftReportView';
import template from 'templates/reports/detail/job/report.tpl';

const JobSummaryReportView = CompositeView.extend({
    template,
    childView: JobShiftReportView,
    childViewOptions: {
        hideHeader: true,
    },
    childViewContainer: '.reports-container',
    templateHelpers() {
        return {
            start: moment(this.model.get('start')).format('M/DD/YY'),
            end: moment(this.model.get('end')).format('M/DD/YY'),
        };
    },
    initialize() {
        this.collection = new Collection(this.model.get('shifts'));
    },
});

export default JobSummaryReportView;
