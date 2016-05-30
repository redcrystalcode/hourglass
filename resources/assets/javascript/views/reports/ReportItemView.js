import {LayoutView} from 'backbone.marionette';
import DisplaysMenu from 'views/mixins/DisplaysMenu';
import {mixin} from 'helpers';
import template from 'templates/reports/item.tpl';

const ReportItemView = LayoutView.extend({
    template,
    tagName: 'li',
    className: 'mdl-list__item mdl-list__item--two-line',
    modelEvents: {
        change: 'render'
    },

    templateHelpers() {
        let type = this.model.get('type');
        const icons = {
            timesheet: 'timer',
            shift: 'assignment',
            job: 'work',
        };
        const types = {
            timesheet: 'Employee Timesheet',
            shift: 'Job Shift Report',
            job: 'Job Summary Report',
        };

        return {
            icon: icons[type],
            type: types[type],
            link: () => {
                let id = this.model.get('id');
                return `/app/reports/${id}`;
            }
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
mixin(ReportItemView, DisplaysMenu);

export default ReportItemView;
