import {ItemView, CompositeView} from 'backbone.marionette';
import Radio from 'backbone.radio';
import moment from 'moment';
import api from 'core/Api';
import ClockedInEmployeesCollection from 'collections/ClockedInEmployeesCollection';
import layout from 'templates/sidebar/layout.tpl';
import item from 'templates/sidebar/item.tpl';
import empty from 'templates/sidebar/empty.tpl';

const EmptyView = ItemView.extend({
    template: empty,
    tagName: 'li',
});
const ChildView = ItemView.extend({
    template: item,
    tagName: 'li',
    className: 'mdl-list__item mdl-list__item--two-line',
    modelEvents: {
        dismiss: 'onClockOut'
    },
    templateHelpers() {
        var model = this.model;
        return {
            time: moment.utc(model.get('time_in')).local().format('h:mm a'),
            date: moment.utc(model.get('time_in')).local().format('MMM D Y'),
        };
    },
    onClockOut() {
        console.log('On Clock Out Item');
        this.$el.addClass('animate animate--slide-out-right').on('animationend', () => {
            this.model.collection.remove(this.model);
        });
    }
});
const OnTheClockSidebarView = CompositeView.extend({
    template: layout,
    className: 'sidebar',
    emptyView: EmptyView,
    childView: ChildView,
    childViewContainer: 'ul.clock-list',
    collectionEvents: {
        request: 'addLoadingState',
        sync: 'removeLoadingState',
    },
    channel: Radio.channel('terminal'),
    initialize() {
        window.channel = this.channel;
        this.listenTo(this.channel, {
            'clock:in': this.onClockIn,
            'clock:out': this.onClockOut,
        });
        this.collection = new ClockedInEmployeesCollection();

        this.setLoadingState(true);
        api.get('terminal/clocked-in').then((response) => {
            this.collection.set(response.data);
            this.setLoadingState(false);
        });
    },

    /**
     * Respond to Clock Out Event
     * @param {object} timesheet - Timesheet object
     */
    onClockIn(timesheet) {
        this.collection.add(timesheet);
    },

    /**
     * Respond to Clock Out Event
     * @param {object} timesheet - Timesheet object
     */
    onClockOut(timesheet) {
        let model = this.collection.findWhere({id: timesheet.id});
        if (!model) {
            return;
        }
        model.trigger('dismiss');
    },

    setLoadingState(loading = true) {
        if (loading) {
            this.$el.addClass('sidebar--loading');
        } else {
            this.$el.removeClass('sidebar--loading');
        }
    },
});

export default OnTheClockSidebarView;
