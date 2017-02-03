import {Collection} from 'backbone';
import {LayoutView} from 'backbone.marionette';
import JobModel from 'models/JobModel';
import LocationsCollection from 'collections/LocationsCollection';
import FormManager from 'components/FormManager';
import MiniChooser from 'components/MiniChooser';
import AddsModelLoadingStateToActionSheet from 'views/mixins/AddsModelLoadingStateToActionSheet';
import {mixin} from 'helpers';
import template from 'templates/jobs/manage-job.tpl';

const ManageJobView = LayoutView.extend({
    template,
    actionSheetOptions() {
        let model = this.model;
        return {
            title: model.isNew() ? 'New Job' : 'Edit Job',
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
        locationChooser: '.location-chooser-region'
    },
    initialize(options) {
        this.model = options.model || new JobModel();
        this.locations = new LocationsCollection();
    },
    onBeforeShow() {
        this.chooser = new MiniChooser({
            showCreateField: false,
            itemIcon: 'business',
            collection: this.locations,
            isFixedHeight: true,
        });
        this.showChildView('locationChooser', this.chooser);
        this.locations.fetch().then(() => {
            let location = this.model.get('location');
            if (!location) {
                return;
            }
            this.locations.findWhere({id: location.id}).set('selected', true);
        });
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
        this.model.set('location', location ? location.toJSON() : null);
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

mixin(ManageJobView, AddsModelLoadingStateToActionSheet);

export default ManageJobView;
