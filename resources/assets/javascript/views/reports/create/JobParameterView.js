import {LayoutView} from 'backbone.marionette';
import SearchesCollection from 'views/mixins/SearchesCollection';
import {mixin} from 'helpers';
import template from 'templates/reports/parameters/job.tpl';

/**
 * Form for creating a Job Summary Report
 */
const JobParametersView = LayoutView.extend({
    template,
});
mixin(JobParametersView, SearchesCollection);

export default JobParametersView;
