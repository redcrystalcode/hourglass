import {LayoutView} from 'backbone.marionette';
import DisplaysMenu from 'views/mixins/DisplaysMenu';
import {mixin} from 'helpers';
import template from 'templates/timesheets/item.tpl';

const TimesheetItemView = LayoutView.extend({
    template,
    tagName: 'li',
    className: 'mdl-list__item mdl-list__item--two-line',
    modelEvents: {
        change: 'render'
    },

    templateHelpers() {
        return {
            icon: 'timer',
        };
    },

    menuOptions() {
        return {
            items: [
                // {key: 'print', label: 'Print'},
                {key: 'delete', label: 'Delete'},
            ]
        };
    },

    onDeleteSelected() {
        this.model.destroy();
    }
});

// Display and manage the menu.
mixin(TimesheetItemView, DisplaysMenu);

export default TimesheetItemView;
