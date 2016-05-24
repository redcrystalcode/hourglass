import {Collection} from 'backbone';
import {LayoutView} from 'backbone.marionette';
import EmployeeModel from 'models/EmployeeModel';
import LocationsCollection from 'collections/LocationsCollection';
import PageableAgenciesCollection from 'collections/PageableAgenciesCollection';
import FormManager from 'components/FormManager';
import MiniChooser from 'components/MiniChooser';
import AddsModelLoadingStateToActionSheet from 'views/mixins/AddsModelLoadingStateToActionSheet';
import {mixin} from 'helpers';
import template from 'templates/terminal/add-employee.tpl';

const AddEmployeeView = LayoutView.extend({
    template,
    actionSheetOptions: {
        title: 'New Employee',
        primaryAction: {
            label: 'Create',
            action: 'save'
        },
        secondaryAction: {
            label: 'Cancel',
            action: 'close'
        }
    },
    regions: {
        locationChooserRegion: '.location-chooser-region',
        agencyChooserRegion: '.agency-chooser-region',
    },
    initialize() {
        this.model = new EmployeeModel();
        this.locations = new LocationsCollection();
        this.agencies = new PageableAgenciesCollection();
    },
    onBeforeShow() {
        this.locationChooser = new MiniChooser({
            showCreateField: false,
            itemIcon: 'business',
            collection: this.locations,
        });
        this.showChildView('locationChooserRegion', this.locationChooser);
        this.locations.fetch();
        this.listenTo(this.locationChooser, 'selected', this.onLocationSelected);

        this.agencyChooser = new MiniChooser({
            showCreateField: false,
            itemIcon: 'business_center',
            collection: this.agencies,
        });
        this.showChildView('agencyChooserRegion', this.agencyChooser);
        this.agencies.fetch();
        this.listenTo(this.agencyChooser, 'selected', this.onAgencySelected);
    },
    onShow() {
        this.formManager = new FormManager({
            form: this.$el.find('form'),
            model: this.model
        });
        this.listenTo(this.formManager, 'save:success', this.onSaveSuccess);
    },
    onLocationSelected(location) {
        this.model.set('location_id', location.get('id'));
    },
    onAgencySelected(agency) {
        this.model.set('agency_id', agency.get('id'));
    },
    onSaveSuccess() {
        this.collection.fetch();
        this.close();
    },
    save() {
        console.log(this.model.toJSON());
        this.formManager.submit();
    },
    close() {
        this.actionSheet.close();
    },
});

mixin(AddEmployeeView, AddsModelLoadingStateToActionSheet);

export default AddEmployeeView;
