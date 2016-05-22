import _ from 'lodash';
import {LayoutView} from 'backbone.marionette';
import nprogress from 'nprogress';
import Radio from 'backbone.radio';
import api from 'core/Api';
import PageableJobsCollection from 'collections/PageableJobsCollection';
import FormValidator from 'components/FormValidator';
import MiniChooser from 'components/MiniChooser';
import TerminalService from 'services/TerminalService';
import template from 'templates/terminal/prompts/select-job.tpl';
import mdl from 'mdl';

const SelectJobPromptView = LayoutView.extend({
    template,

    ui: {
        input: 'input[name=terminal_key]',
        search: 'input[name=search]',
        submit: '.js-submit',
        form: 'form',
    },

    events: {
        'click .js-cancel': 'cancel',
        'submit @ui.form': 'onFormSubmit',
        'click @ui.submit': 'submit',
        'keyup @ui.search': 'handleSearchInput',
    },

    regions: {
        jobSearch: '.job-search-region'
    },

    channel: Radio.channel('terminal'),

    onBeforeShow() {
        this.jobs = new PageableJobsCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            secondaryField: function(model) {
                return '#' + model.get('number');
            },
            itemIcon: 'work',
            collection: this.jobs,
        });
        this.showChildView('jobSearch', this.chooser);
        this.jobs.fetch();
        this.listenTo(this.chooser, 'selected', this.onJobSelected);
    },

    onShow() {
        mdl.upgradeAllRegistered();
        this.validator = new FormValidator({
            form: this.ui.form
        });
        this.ui.input.focus();
    },

    cancel() {
        TerminalService.request('index');
    },

    onJobSelected(job) {
        this.selectedJob = job;
        this.ui.submit.attr('disabled', false);
    },

    onFormSubmit(e) {
        e.preventDefault();
    },

    submit() {
        if (!this.selectedJob) {
            return;
        }

        nprogress.start();
        api.post('terminal/clock', null, {
            terminal_key: this.model.get('terminal_key'),
            job_id: this.selectedJob.get('id')
        }).then(this.handleResponse.bind(this)).catch((errors) => {
            console.log(errors);
            this.validator.showServerErrors(errors);
            nprogress.done();
        });
    },

    handleResponse(response) {
        nprogress.done();
        console.log(response);

        // If clocked out:
        this.channel.trigger('clock:in', response.data);
        TerminalService.request('index');
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
    }
});

export default SelectJobPromptView;
