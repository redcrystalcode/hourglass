import {Collection} from 'backbone';
import {LayoutView} from 'backbone.marionette';
import EmployeeModel from 'models/EmployeeModel';
import LocationsCollection from 'collections/LocationsCollection';
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
        locationChooser: '.location-chooser-region'
    },
    initialize() {
        this.model = new EmployeeModel();
        this.locations = new LocationsCollection();
    },
    onBeforeShow() {
        this.chooser = new MiniChooser({
            showCreateField: false,
            itemIcon: 'business',
            collection: this.locations,
        });
        this.showChildView('locationChooser', this.chooser);
        this.locations.fetch();
        this.listenTo(this.chooser, 'selected', this.onLocationSelected);
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
