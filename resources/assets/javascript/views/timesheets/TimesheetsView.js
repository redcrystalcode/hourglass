import {ItemView, LayoutView, CompositeView} from 'backbone.marionette';
import ActionSheet from 'components/ActionSheet';
// import ManageTimesheetView from 'views/timesheets/ManageTimesheetView';
import DisplaysMenu from 'views/mixins/DisplaysMenu';
import Confirm from 'components/Confirm';
import {mixin, time} from 'helpers';
import template from 'templates/timesheets/list.tpl';
import itemTemplate from 'templates/timesheets/item.tpl';
import emptyTemplate from 'templates/timesheets/empty.tpl';
import moment from "moment";

const TimesheetItemView = LayoutView.extend({
    template: itemTemplate,
    tagName: 'tr',

    events: {
    },

    modelEvents: {
        sync: 'render'
    },

    menuOptions: {
        items: [
            {key: 'edit', label: 'Edit'},
            {key: 'delete', label: 'Delete'},
        ],
    },

    templateHelpers() {
        let model = this.model;
        return {
            date: moment.utc(model.get('time_in')).local().format('ddd, MMM D, Y'),
            name: model.get('employee').name,
            time_in: time(model.get('time_in')),
            time_out: time(model.get('time_out')),
            job() {
                let job = model.get('job');
                let shift = model.get('shift');
                return `#${job.number} (Shift #${shift.id})`;
            },
            total_time() {
                let duration = moment.duration(
                    moment.utc(model.get('time_out')).diff(moment.utc(model.get('time_in')))
                );

                return `${duration.hours()}h ${duration.minutes()}m`;
            }
        };
    },

    onEditSelected() {
        let sheet = new ActionSheet({
            view: new ManageTimesheetView({
                model: this.model,
            })
        });
        sheet.open();
    },

    onDeleteSelected() {
        Confirm.confirm({
            title: 'Delete rounding rule?',
            body: 'This rounding rule will no longer apply to any reports. Are you sure you want to delete it?',
            primaryAction: 'Delete',
        }).done(() => this.model.destroy());
    }
});
mixin(TimesheetItemView, DisplaysMenu);

const TimesheetEmptyView = ItemView.extend({
    template: emptyTemplate,
    tagName: 'tr',
});

const TimesheetsView = CompositeView.extend({
    template,
    childViewContainer: 'tbody',
    childView: TimesheetItemView,
    emptyView: TimesheetEmptyView,

    collectionEvents: {
        sync: 'render',
    },

    events: {
        'click .js-add-rule': 'showAddRuleActionSheet',
        'click .js-page-prev': 'previousPage',
        'click .js-page-next': 'nextPage',
    },

    templateHelpers() {
        let collection = this.collection;
        return {
            pagination: {
                total: collection.getTotalRecords(),
                start: collection.getPageStart(),
                end: collection.getPageEnd(),
                enable_prev: collection.hasPreviousPage(),
                enable_next: collection.hasNextPage(),
            }
        };
    },

    showAddRuleActionSheet() {
        let sheet = new ActionSheet({
            // view: new ManageTimesheetView({
            //     collection: this.collection,
            // })
        });
        sheet.open();
    },

    previousPage(e) {
        e.preventDefault();
        this.collection.getPreviousPage();
    },

    nextPage(e) {
        e.preventDefault();
        this.collection.getNextPage();
    }
});

export default TimesheetsView;
