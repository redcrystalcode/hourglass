import {Collection} from 'backbone';
import {CompositeView, ItemView} from 'backbone.marionette';
import moment from 'moment';
import _ from 'lodash';
import {time} from 'helpers';
import template from 'templates/reports/detail/timesheet/report.tpl';
import item from 'templates/reports/detail/timesheet/table-row.tpl';
import empty from 'templates/reports/detail/timesheet/empty.tpl';

const TableRowView = ItemView.extend({
    tagName: 'tr',
    template: item,
    templateHelpers() {
        var model = this.model;
        return {
            date: moment.utc(model.get('time_in')).local().format('ddd, MMM D, Y'),
            time_in: time(model.get('time_in')),
            time_out: time(model.get('time_out')),
            original_time_in: time(model.get('original_time_in')),
            original_time_out: time(model.get('original_time_out')),
            job() {
                var job = model.get('job');
                return `#${job.number} - ${job.name}`;
            },
            total_time() {
                let duration = moment.duration(
                    moment.utc(model.get('time_out')).diff(moment.utc(model.get('time_in')))
                );

                return `${duration.hours()}h ${duration.minutes()}m`;
            }
        };
    },
});

const EmployeeTimesheetReportView = CompositeView.extend({
    template,
    childView: TableRowView,
    childViewContainer: 'tbody',
    emptyView: ItemView.extend({
        tagName: 'tr',
        template: empty,
    }),
    templateHelpers() {
        let view = this;
        return {
            start: moment(this.model.get('start')).format('M/DD/YY'),
            end: moment(this.model.get('end')).format('M/DD/YY'),
            total_time() {
                let total = moment.duration(0, 'seconds');
                _.each(view.model.get('timesheets'), (timesheet) => {
                    let diffInSeconds = moment(timesheet.time_out).diff(moment(timesheet.time_in), 'seconds');
                    total.add(moment.duration(diffInSeconds, 'seconds'));
                });
                // let hours = Math.floor(total / 60);
                // let minutes = total % 60;
                // return `${hours}h ${minutes}m`;
                return `${Math.floor(total.asHours())}h ${Math.floor(total.minutes())}m`;
            },
            show_meta: !this.hideMetaHeader
        };
    },
    initialize(options) {
        this.hideMetaHeader = options.hideMetaHeader || false;
        this.collection = new Collection(this.model.get('timesheets'));
    },
});

export default EmployeeTimesheetReportView;
