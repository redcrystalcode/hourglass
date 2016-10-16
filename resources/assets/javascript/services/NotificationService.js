import Service from 'backbone.service';
import Radio from 'backbone.radio';
import moment from 'moment';

const NotificationService = Service.extend({
    channel: Radio.channel('notifications'),

    requests: {
        'notify': 'showNotification',
        'notify:clock:in': 'showClockInNotification',
        'notify:clock:out': 'showClockOutNotification',
    },

    showNotification(notification) {
        this.channel.trigger('show', notification);
    },

    showClockInNotification(timesheet) {
        let notification = {
            icon: 'timer',
            primary: `${timesheet.name} clocked in.`,
            secondary: `#${timesheet.job.number} - ${timesheet.job.name}`,
            timestamp: moment.utc(timesheet.time_in).local()
        };

        this.showNotification(notification);
    },

    showClockOutNotification(timesheet) {
        let timeIn = moment.utc(timesheet.time_in).local();
        let timeOut = moment.utc(timesheet.time_out).local();
        let timeWorked = timeOut.diff(timeIn, 'hours', true).toFixed(1);

        let notification = {
            icon: 'timer_off',
            primary: `${timesheet.name} clocked out.`,
            secondary: `${timeWorked} hours on #${timesheet.job.number}`,
            timestamp: timeOut
        };

        this.showNotification(notification);
    }
});

let instance = new NotificationService();
window.notifications = instance;
window.moment = moment;
export default instance;
