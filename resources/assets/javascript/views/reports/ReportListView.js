import {Collection} from 'backbone';
import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import ReportItemView from 'views/reports/ReportItemView';
import PageableReportsCollection from 'collections/PageableReportsCollection';
import CreateReportView from 'views/reports/CreateReportView';
import template from 'templates/reports/list.tpl';

const JobListView = LayoutView.extend({
    template,

    regions: {
        reports: '.list-region'
    },

    events: {
        'click .js-new-report-button': 'showCreateReportActionSheet',
    },

    initialize() {
        this.reports = new PageableReportsCollection();
    },

    onBeforeShow() {
        this.showChildView('reports', new CollectionCard({
            collection: this.reports,
            childView: ReportItemView,
            emptyView: EmptyView.extend({
                icon: 'assessment',
                heading: "There's nothing here.",
                subhead: 'Looks like there are no reports here. '
                    + 'Reports you create will show up here!'
            })
        }));
        this.reports.fetch();
    },

    showCreateReportActionSheet() {
        var sheet = new ActionSheet({
            view: new CreateReportView({
                collection: this.reports
            }),
        });
        sheet.open();
    }
});

export default JobListView;
