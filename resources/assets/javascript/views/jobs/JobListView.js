import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import JobItemView from 'views/jobs/JobItemView';
import ManageJobView from 'views/jobs/ManageJobView';
import PushesCollectionState from 'views/mixins/PushesCollectionState';
import {mixin} from 'helpers';
import template from 'templates/jobs/list.tpl';

const JobListView = LayoutView.extend({
    template,

    regions: {
        jobs: '.jobs-region'
    },

    events: {
        'click .js-add-job-button': 'showAddJobActionSheet',
    },

    onBeforeShow() {
        this.showChildView('jobs', new CollectionCard({
            collection: this.collection,
            childView: JobItemView,
            emptyView: EmptyView.extend({
                icon: 'work',
                heading: "There's nothing here.",
                subhead: 'Looks like there are no jobs here. Try adding one!'
            }),
        }));
    },

    showAddJobActionSheet() {
        let sheet = new ActionSheet({
            view: new ManageJobView({collection: this.collection})
        });
        sheet.open();
    }
});
mixin(JobListView, PushesCollectionState);

export default JobListView;
