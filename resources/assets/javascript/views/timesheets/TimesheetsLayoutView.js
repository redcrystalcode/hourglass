import {LayoutView} from 'backbone.marionette';
import TimesheetsView from 'views/timesheets/TimesheetsView';
import template from 'templates/timesheets/layout.tpl';

const TimesheetsLayoutView = LayoutView.extend({
    template,

    regions: {
        timesheetsRegion: '.timesheets-region',
    },

    onBeforeShow() {
        this.showChildView('timesheetsRegion', new TimesheetsView({
            collection: this.options.timesheets,
        }));
    },
});

export default TimesheetsLayoutView;
