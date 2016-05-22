import {LayoutView} from 'backbone.marionette';
import JobListView from 'views/jobs/JobListView';
import template from 'templates/jobs/layout.tpl';

const JobsLayoutView = LayoutView.extend({
    template,

    regions: {
        jobs: '.job-list-region',
    },

    onBeforeShow() {
        this.showChildView('jobs', new JobListView());
    },
});

export default JobsLayoutView;
