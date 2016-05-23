import _ from 'lodash';
import {LayoutView} from 'backbone.marionette';
import nprogress from 'nprogress';
import PageableJobsCollection from 'collections/PageableJobsCollection';
import MiniChooser from 'components/MiniChooser';
import ActionSheet from 'components/ActionSheet';
import TerminalService from 'services/TerminalService';
import ManageJobView from 'views/jobs/ManageJobView';
import template from 'templates/terminal/prompts/express-select-job.tpl';
import mdl from 'mdl';

const ExpressSelectJobPromptView = LayoutView.extend({
    template,

    ui: {
        search: 'input[name=search]',
        submit: '.js-continue',
    },

    events: {
        'click .js-cancel': 'cancel',
        'click .js-new-job': 'showAddJobActionSheet',
        'click @ui.submit': 'submit',
        'keyup @ui.search': 'handleSearchInput',
    },

    regions: {
        jobSearch: '.job-search-region'
    },

    onBeforeShow() {
        this.jobs = new PageableJobsCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            primaryField: function(model) {
                return '#' + model.get('number');
            },
            secondaryField: 'name',
            itemIcon: 'work',
            collection: this.jobs,
        });
        this.showChildView('jobSearch', this.chooser);
        this.jobs.setSorting('created_at', 1);
        this.jobs.fetch();
        this.listenTo(this.chooser, 'selected', this.onJobSelected);
    },

    onShow() {
        mdl.upgradeAllRegistered();
        this.ui.search.focus();
    },

    cancel() {
        TerminalService.request('index');
    },

    onJobSelected(job) {
        this.selectedJob = job;
        this.ui.submit.attr('disabled', false);
    },

    submit() {
        if (!this.selectedJob) {
            return;
        }

        TerminalService.request('express:clock', this.selectedJob);
    },

    handleSearchInput() {
        var val = this.ui.search.val();

        if (val.length < 1) {
            this.clearSearch();
            return;
        }

        this.search(val);
    },

    search(keyword) {
        // Just in case this gets called elsewhere, update the UI.
        this.ui.search.val(keyword);

        if (!this.doSearch) {
            this.doSearch = _.debounce((keyword) => {
                this.jobs.search(keyword);
            }, 300, {trailing: true});
        }
        this.doSearch(keyword);
    },

    clearSearch() {
        this.ui.search.val('');
        this.jobs.fetch();
    },

    showAddJobActionSheet() {
        var sheet = new ActionSheet({
            view: new ManageJobView({collection: this.jobs})
        });
        sheet.open();
    }
});

export default ExpressSelectJobPromptView;
