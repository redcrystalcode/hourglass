import {LayoutView} from 'backbone.marionette';
import MiniChooser from 'components/MiniChooser';
import DatePicker from 'components/DatePicker';
import PageableAgenciesCollection from 'collections/PageableAgenciesCollection';
import SearchesCollection from 'views/mixins/SearchesCollection';
import {mixin} from 'helpers';
import mdl from 'mdl';
import template from 'templates/reports/parameters/agency.tpl';

/**
 * Form for creating a Timesheet Report
 */
const AgencyParameterView = LayoutView.extend({
    template,
    regions: {
        agencyChooser: '.agency-chooser-region'
    },
    ui: {
        startDate: '.js-date-start',
        endDate: '.js-date-end',
    },
    onBeforeShow() {
        this.collection = new PageableAgenciesCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            itemIcon: 'business_center',
            collection: this.collection,
        });
        this.showChildView('agencyChooser', this.chooser);
        this.collection.fetch();
        this.listenTo(this.chooser, 'selected', this.onEmployeeSelected);
    },
    onShow() {
        mdl.upgradeAllRegistered();
        new DatePicker({field: this.ui.startDate});
        new DatePicker({field: this.ui.endDate});
    },
    onEmployeeSelected(agency) {
        this.model.set('agency_id', agency.get('id'));
    }
});
mixin(AgencyParameterView, SearchesCollection);

export default AgencyParameterView;
