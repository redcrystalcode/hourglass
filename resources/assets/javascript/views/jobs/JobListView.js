import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import JobItemView from 'views/jobs/JobItemView';
import PageableJobsCollection from 'collections/PageableJobsCollection';
import ManageJobView from 'views/jobs/ManageJobView';
import template from 'templates/jobs/list.tpl';

const JobListView = LayoutView.extend({
    template,

    regions: {
        jobs: '.jobs-region'
    },

    events: {
        'click .js-add-job-button': 'showAddJobActionSheet',
    },

    initialize() {
        this.jobs = new PageableJobsCollection();
    },

    onBeforeShow() {
        this.showChildView('jobs', new CollectionCard({
            collection: this.jobs,
            childView: JobItemView,
            emptyView: EmptyView.extend({
                icon: 'work',
                heading: "There's nothing here.",
                subhead: 'Looks like there are no jobs here. Try adding one!'
            })
        }));
        this.jobs.fetch();
    },

    showAddJobActionSheet() {
        var sheet = new ActionSheet({
            view: new ManageJobView({collection: this.jobs})
        });
        sheet.open();
    }
});

export default JobListView;
