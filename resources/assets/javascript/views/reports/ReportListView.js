import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import ReportItemView from 'views/reports/ReportItemView';
import CreateReportView from 'views/reports/create/CreateReportView';
import PushesCollectionState from 'views/mixins/PushesCollectionState';
import {mixin} from 'helpers';
import template from 'templates/reports/list.tpl';

const ReportListView = LayoutView.extend({
    template,

    regions: {
        reports: '.list-region'
    },

    events: {
        'click .js-new-report-button': 'showCreateReportActionSheet',
    },

    onBeforeShow() {
        this.showChildView('reports', new CollectionCard({
            collection: this.collection,
            childView: ReportItemView,
            emptyView: EmptyView.extend({
                icon: 'assessment',
                heading: "There's nothing here.",
                subhead: 'Looks like there are no reports here. '
                    + 'Reports you create will show up here!'
            })
        }));
    },

    showCreateReportActionSheet() {
        let sheet = new ActionSheet({
            view: new CreateReportView(),
        });
        sheet.open();
    }
});

mixin(ReportListView, PushesCollectionState);

export default ReportListView;
