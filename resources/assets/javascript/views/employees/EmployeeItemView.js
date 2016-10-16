import {LayoutView} from 'backbone.marionette';
import DisplaysMenu from 'views/mixins/DisplaysMenu';
import Confirm from 'components/Confirm';;
import ActionSheet from 'components/ActionSheet';
import ManageEmployeeView from 'views/employees/ManageEmployeeView';
import {mixin} from 'helpers';
import template from 'templates/employees/item.tpl';

const EmployeeItemView = LayoutView.extend({
    template,
    tagName: 'li',
    className: 'mdl-list__item mdl-list__item--two-line',
    modelEvents: {
        sync: 'render'
    },

    menuOptions() {
        let items = [];
        if (this.model.get('archived')) {
            items = [
                // {key: 'restore', label: 'Restore'}
            ];
        } else {
            items = [
                {key: 'edit', label: 'Edit'},
                {key: 'archive', label: 'Archive'},
            ];
        }
        return {items};
    },

    templateHelpers() {
        return {
            terminal_key: this.model.getCleanTerminalKey(),
        };
    },

    onEditSelected() {
        let sheet = new ActionSheet({
            view: new ManageEmployeeView({
                collection: this.model.collection,
                model: this.model
            })
        });
        sheet.open();
    },

    onArchiveSelected() {
        Confirm.confirm({
            title: 'Archive this employee?',
            body: "After you archive this employee, they will no longer be able to clock in or out."
                + "The employee will still be available for all your reports."
                + "<span class=\"dialog__body-subtext\">Note: Archived employees will appear"
                + " last in the list of employees.</span>",
            primaryAction: 'Archive',
        }).done(() => {
            this.model.archive().then(() => this.model.collection.fetch());
        });
    }
});

// Display and manage the menu.
mixin(EmployeeItemView, DisplaysMenu);

export default EmployeeItemView;
