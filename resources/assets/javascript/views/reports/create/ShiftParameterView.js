import moment from 'moment';
import {LayoutView} from 'backbone.marionette';
import PageableShiftsCollection from 'collections/PageableShiftsCollection';
import MiniChooser from 'components/MiniChooser';
import SearchesCollection from 'views/mixins/SearchesCollection';
import {mixin} from 'helpers';
import mdl from 'mdl';
import template from 'templates/reports/parameters/shift.tpl';

/**
 * Form for creating a Shift Report
 */
const ShiftParametersView = LayoutView.extend({
    template,
    regions: {shiftChooser: '.shift-chooser-region'},
    onBeforeShow() {
        this.collection = new PageableShiftsCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            itemIcon: 'assignment',
            primaryField(model) {
                return '#' + model.get('job').number;
            },
            secondaryField(model) {
                return moment.utc(model.get('created_at')).local().format('M/DD/YY');
            },
            collection: this.collection,
        });
        this.showChildView('shiftChooser', this.chooser);
        this.collection.fetch();
        this.listenTo(this.chooser, 'selected', this.onShiftSelected);
    },
    onShow() {
        mdl.upgradeAllRegistered();
    },
    onShiftSelected(shift) {
        this.model.set('job_shift_id', shift.get('id'));
    },
});
mixin(ShiftParametersView, SearchesCollection);

export default ShiftParametersView;
