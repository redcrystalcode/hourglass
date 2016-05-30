import {LayoutView} from 'backbone.marionette';
import template from 'templates/reports/detail/print.tpl';

const PrintReportView = LayoutView.extend({
    template,
    regions: {
        contents: '.app',
    },
    onBeforeShow() {
        this.showChildView('contents', this.options.contentView);
    }
});

export default PrintReportView;
