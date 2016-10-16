import {LayoutView} from 'backbone.marionette';
import ReportListView from 'views/reports/ReportListView';
import template from 'templates/reports/layout.tpl';

const ReportsLayoutView = LayoutView.extend({
    template,

    regions: {
        reportsRegion: '.reports-region',
    },

    onBeforeShow() {
        this.showChildView('reportsRegion', new ReportListView({
            collection: this.options.reports,
        }));
    },
});

export default ReportsLayoutView;
