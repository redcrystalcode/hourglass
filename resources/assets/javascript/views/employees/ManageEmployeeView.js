import {Collection} from 'backbone';
import {LayoutView} from 'backbone.marionette';
import EmployeeModel from 'models/EmployeeModel';
import LocationsCollection from 'collections/LocationsCollection';
import PageableAgenciesCollection from 'collections/PageableAgenciesCollection';
import FormManager from 'components/FormManager';
import MiniChooser from 'components/MiniChooser';
import AddsModelLoadingStateToActionSheet from 'views/mixins/AddsModelLoadingStateToActionSheet';
import {mixin} from 'helpers';
import template from 'templates/employees/manage-employee.tpl';

const ManageEmployeeView = LayoutView.extend({
    template,
    actionSheetOptions() {
        let model = this.model;
        return {
            title: model.isNew() ? 'New Employee' : 'Edit Employee',
            primaryAction: {
                label: model.isNew() ? 'Create' : 'Save',
                action: 'save'
            },
            secondaryAction: {
                label: 'Cancel',
                action: 'close'
            }
        };
    },
    regions: {
        locationChooserRegion: '.location-chooser-region',
        agencyChooserRegion: '.agency-chooser-region',
    },
    initialize(options) {
        this.model = options.model || new EmployeeModel();
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
        this.locations.fetch().then(() => {
            let location = this.model.get('location');
            if (!location) {
                return;
            }
            this.locations.findWhere({id: location.id}).set('selected', true);
        });
        this.listenTo(this.locationChooser, 'selected', this.onLocationSelected);

        this.agencyChooser = new MiniChooser({
            showCreateField: false,
            itemIcon: 'business_center',
            collection: this.agencies,
        });
        this.showChildView('agencyChooserRegion', this.agencyChooser);
        this.agencies.fetch().then(() => {
            let agency = this.model.get('agency');
            if (!agency) {
                return;
            }
            this.agencies.findWhere({id: agency.id}).set('selected', true);
        });
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
        this.model.set('location', location.toJSON());
    },
    onAgencySelected(agency) {
        this.model.set('agency', agency ? agency.toJSON() : null);
    },
    onSaveSuccess() {
        this.collection.fetch();
        this.close();
    },
    save() {
        this.formManager.submit();
    },
    close() {
        this.actionSheet.close();
    },
});

mixin(ManageEmployeeView, AddsModelLoadingStateToActionSheet);

export default ManageEmployeeView;
