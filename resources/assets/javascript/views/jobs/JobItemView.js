import {LayoutView} from 'backbone.marionette';
import DisplaysMenu from 'views/mixins/DisplaysMenu';
import Dialog from 'components/Dialog';
import ActionSheet from 'components/ActionSheet';
import ManageJobView from 'views/jobs/ManageJobView';
import {mixin} from 'helpers';
import template from 'templates/jobs/item.tpl';

const JobItemView = LayoutView.extend({
    template,
    tagName: 'li',
    className: 'mdl-list__item mdl-list__item--two-line',
    modelEvents: {
        change: 'render'
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

    onEditSelected() {
        let sheet = new ActionSheet({
            view: new ManageJobView({
                collection: this.model.collection,
                model: this.model
            })
        });
        sheet.open();
    },

    onArchiveSelected() {
        Dialog.open({
            title: 'Archive job?',
            body: "After you archive this job, employees will no longer be able to clock in to it. "
                + "The job will still be available for all your reports."
                + "<span class=\"dialog__body-subtext\">Note: Archived jobs will appear last in the list of jobs.</span>",
            primaryAction: 'Archive',
        }).done(() => this.model.archive());
    }
});

// Display and manage the menu.
mixin(JobItemView, DisplaysMenu);

export default JobItemView;
