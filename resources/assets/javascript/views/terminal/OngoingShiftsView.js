import {Collection} from 'backbone';
import {CompositeView, ItemView} from 'backbone.marionette';
import moment from 'moment';
import TerminalService from 'services/TerminalService';
import OngoingShiftsCollection from 'collections/OngoingShiftsCollection';
import layout from 'templates/terminal/shifts/layout.tpl';
import item from 'templates/terminal/shifts/item.tpl';

const ShiftItemView = ItemView.extend({
    template: item,
    className: 'mdl-cell mdl-cell--4-col mdl-cell--6-col-tablet',
    events: {
        'click .js-end-job': 'endShift',
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
});
const OngoingShiftsView = CompositeView.extend({
    template: layout,
    className: 'shifts-container',
    childView: ShiftItemView,
    childViewContainer: '.js-shifts-list-container',
    initialize() {
        this.collection = new OngoingShiftsCollection();
        this.listenTo(this.collection, {
            request: this.onRequest,
            sync: this.onSync,
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
