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
        let model = this.model;
        return {
            dates() {
                let start = model.get('start');
                let end = model.get('end');
                if (start === null) {
                    return 'Not Started';
                }
                if (start === end) {
                    return moment(start).format('M/DD/YY');
                }
                return `${moment(start).format('M/DD/YY')} &mdash; ${moment(end).format('M/DD/YY')}`;
            },
            total_time() {
                const totals = model.get('totals');
                let total = moment.duration(totals.minutes, 'minutes');

                return `${Math.floor(total.asHours())}h ${Math.floor(total.minutes())}m`;
            }
        };
    },
    initialize() {
        this.collection = new Collection(this.model.get('shifts'));
    },
});

export default JobSummaryReportView;
