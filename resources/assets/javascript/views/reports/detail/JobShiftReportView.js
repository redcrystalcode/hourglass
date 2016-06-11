import {Collection} from 'backbone';
import {CompositeView, ItemView} from 'backbone.marionette';
import moment from 'moment';
import _ from 'lodash';
import template from 'templates/reports/detail/shift/report.tpl';
import item from 'templates/reports/detail/shift/table-row.tpl';

const TableRowView = ItemView.extend({
    tagName: 'tr',
    template: item,
    templateHelpers() {
        var model = this.model;
        return {
            date: moment.utc(model.get('time_in')).local().format('ddd, MMM D, Y'),
            time_in: moment.utc(model.get('time_in')).local().format('hh:mm A'),
            time_out: moment.utc(model.get('time_out')).local().format('hh:mm A'),
            total_time() {
                let duration = moment.duration(
                    moment.utc(model.get('time_out')).diff(moment.utc(model.get('time_in')))
                );

                return `${Math.floor(duration.asHours())}h ${Math.floor(duration.minutes())}m`;
            }
        };
    },
});

const JobShiftReportView = CompositeView.extend({
    template,
    childView: TableRowView,
    childViewContainer: 'tbody',
    templateHelpers() {
        let view = this;
        return {
            show_header: !this.hideHeader,
            date() {
                let start = moment.utc(view.model.get('start')).local().format('M/DD/YY');
                let end = moment.utc(view.model.get('end')).local().format('M/DD/YY')
                if (start === end) {
                    return start;
                }
                return `${start} &mdash; ${end}`;
            },
            setup() {
                let setup = view.getSetupDuration();
                if (!setup) {
                    return null;
                }

                return `${Math.floor(setup.asHours())}h ${Math.floor(setup.minutes())}m`;
            },
            total_time() {
                let total = moment.duration(0, 'seconds');
                _.each(view.model.get('timesheets'), (timesheet) => {
                    let diffInSeconds = moment(timesheet.time_out).diff(moment(timesheet.time_in), 'seconds');
                    total.add(moment.duration(diffInSeconds, 'seconds'));
                });
                let setup = view.getSetupDuration();
                total.subtract(setup);
                return `${Math.floor(total.asHours())}h ${Math.floor(total.minutes())}m`;
            }
        };
    },

    initialize(options) {
        this.hideHeader = Boolean(options.hideHeader);
        this.collection = new Collection(this.model.get('timesheets'));
    },

    getSetupDuration() {
        let productivity = this.model.get('shift').productivity;
        if (!productivity || !productivity.setup) {
            return null;
        }
        return moment.duration(parseFloat(productivity.setup), 'hours');
    }
});

export default JobShiftReportView;
