import _ from 'lodash';
import api from 'core/Api';
import Radio from 'backbone.radio';
import {CompositeView, ItemView} from 'backbone.marionette';
import moment from 'moment';
import TerminalService from 'services/TerminalService';
import NotificationService from 'services/NotificationService';
import OngoingShiftsCollection from 'collections/OngoingShiftsCollection';
import EmptyView from 'components/EmptyView';
import Dialog from 'components/Dialog';
import layout from 'templates/terminal/shifts/layout.tpl';
import item from 'templates/terminal/shifts/item.tpl';

const ShiftItemView = ItemView.extend({
    template: item,
    className: 'mdl-cell mdl-cell--4-col mdl-cell--6-col-tablet',
    channel: Radio.channel('terminal'),
    events: {
        'click .js-end-shift': 'endShift',
        'click .js-pause-shift': 'pauseShift',
        'click .js-resume-shift': 'resumeShift',
    },
    modelEvents: {
        change: 'render',
    },
    templateHelpers() {
        let start = this.model.get('created_at');
        return {
            start_date: moment.utc(start).local().format('MMM D Y')
        };
    },
    endShift() {
        TerminalService.endShift(this.model);
    },
    pauseShift() {
        Dialog.open({
            title: 'Pause shift?',
            body: 'Pausing this shift will clock out all employees currently clocked in to this shift. '
                + 'You can resume a shift at any time. All employees will be clocked back in upon resuming.',
            primaryAction: 'Pause Shift',
        }).then(() => {
            return api.post('/terminal/shifts/%s/pause', this.model.get('id'))
                .then(this.onShiftPaused.bind(this));
        });
    },
    resumeShift() {
        Dialog.open({
            title: 'Resume shift?',
            body: 'Resuming this shift will clock in all employees that were clocked in at the time you paused '
                + 'this shift.',
            primaryAction: 'Resume Shift',
        }).then(() => {
            api.post('/terminal/shifts/%s/resume', this.model.get('id'))
                .then(this.onShiftResumed.bind(this));
        });
    },
    onShiftPaused(response) {
        _.each(response.data, (timesheet) => {
            this.channel.trigger('clock:out', timesheet);
        });
        NotificationService.request('notify', {
            icon: 'pause',
            primary: 'Shift Paused',
            secondary: `#${this.model.get('job').number} - ${this.model.get('job').name}`,
        });
        this.model.set('paused', true);
    },
    onShiftResumed(response) {
        _.each(response.data, (timesheet) => {
            this.channel.trigger('clock:in', timesheet);
        });
        NotificationService.request('notify', {
            icon: 'play_arrow',
            primary: 'Shift Resumed',
            secondary: `#${this.model.get('job').number} - ${this.model.get('job').name}`,
        });
        this.model.set('paused', false);
    }
});
const OngoingShiftsView = CompositeView.extend({
    template: layout,
    className: 'shifts-container',
    childView: ShiftItemView,
    childViewContainer: '.js-shifts-list-container',
    emptyView: EmptyView.extend({
        icon: 'assignment_turned_in',
        heading: "No ongoing shifts!",
        subhead: 'As employees clock in, new shifts will be added here.'
    }),
    channel: Radio.channel('terminal'),
    initialize() {
        this.collection = new OngoingShiftsCollection();
        this.listenTo(this.collection, {
            request: this.onRequest,
            sync: this.onSync,
        });
        this.listenTo(this.channel, 'clock:in', () => {
            this.collection.fetch();
        });
    },
    onShow() {
        this.collection.fetch();
    },
    onRequest() {
        this.setLoadingState(true);
    },
    onSync() {
        this.setLoadingState(false);
    },
    setLoadingState(loading = true) {
        if (loading) {
            this.$el.addClass('shifts-container--loading');
        } else {
            this.$el.removeClass('shifts-container--loading');
        }
    }
});

export default OngoingShiftsView;
