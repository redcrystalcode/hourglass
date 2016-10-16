import $ from 'jquery';
import {LayoutView} from 'backbone.marionette';
import ReportModel from 'models/ReportModel';
import ApplicationService from 'services/ApplicationService';
import FormValidator from 'components/FormValidator';
import TimesheetParameterView from 'views/reports/create/TimesheetParameterView';
import AgencyParameterView from 'views/reports/create/AgencyParameterView';
import ShiftParameterView from 'views/reports/create/ShiftParameterView';
import JobParameterView from 'views/reports/create/JobParameterView';
import AddsModelLoadingStateToActionSheet from 'views/mixins/AddsModelLoadingStateToActionSheet';
import {mixin, getFormData} from 'helpers';
import template from 'templates/reports/create.tpl';

/**
 * Map report types to parameter views.
 */
const ParameterViews = {
    timesheet: TimesheetParameterView,
    agency: AgencyParameterView,
    shift: ShiftParameterView,
    job: JobParameterView,
};

/**
 * Outer action sheet w/ type selector.
 */
const CreateReportView = LayoutView.extend({
    template,
    ui: {
        type: 'input[name=type]',
        form: 'form'
    },
    events: {
        'change @ui.type': 'onTypeChanged'
    },
    regions: {
        parameters: '.report-parameters-region',
    },
    actionSheetOptions() {
        return {
            title: 'Create Report',
            primaryAction: {
                label: 'Create',
                action: 'createReport'
            },
            secondaryAction: {
                label: 'Cancel',
                action: 'close'
            }
        };
    },
    initialize() {
        // Store job parameters here.
        this.model = new ReportModel();
    },
    onShow() {
        this.validator = new FormValidator({form: this.ui.form});
    },
    onTypeChanged(e) {
        let type = $(e.currentTarget).val();
        this.showReportParametersForm(type);
    },
    showReportParametersForm(type) {
        let ViewClass = ParameterViews[type];

        this.showChildView('parameters', new ViewClass({
            model: this.model
        }));
    },
    createReport() {
        this.model.set(getFormData(this.ui.form));
        this.model.save().then(() => {
            this.actionSheet.close();
            ApplicationService.request('route', `/reports/${this.model.get('id')}`);
        }).catch((errors) => {
            this.validator.showServerErrors(errors);
        });
    },
});

mixin(CreateReportView, AddsModelLoadingStateToActionSheet);

export default CreateReportView;
