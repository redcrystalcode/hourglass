import {LayoutView} from 'backbone.marionette';
import PageableJobsCollection from 'collections/PageableJobsCollection';
import MiniChooser from 'components/MiniChooser';
import DatePicker from 'components/DatePicker';
import SearchesCollection from 'views/mixins/SearchesCollection';
import {mixin} from 'helpers';
import mdl from 'mdl';
import template from 'templates/reports/parameters/job.tpl';

/**
 * Form for creating a Job Summary Report
 */
const JobParametersView = LayoutView.extend({
    template,
    regions: {
        jobChooser: '.job-chooser-region'
    },
    onBeforeShow() {
        this.collection = new PageableJobsCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            itemIcon: 'assignment',
            primaryField(model) {
                return '#' + model.get('number');
            },
            secondaryField: 'name',
            collection: this.collection,
        });
        this.showChildView('jobChooser', this.chooser);
        this.collection.fetch();
        this.listenTo(this.chooser, 'selected', this.onJobSelected);
    },
    onShow() {
        mdl.upgradeAllRegistered();
        new DatePicker({field: this.ui.startDate});
        new DatePicker({field: this.ui.endDate});
    },
    onJobSelected(job) {
        this.model.set('job_id', job.get('id'));
    },
});
mixin(JobParametersView, SearchesCollection);

export default JobParametersView;
