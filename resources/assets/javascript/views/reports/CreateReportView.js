import $ from 'jquery';
import moment from 'moment';
import {LayoutView} from 'backbone.marionette';
import PageableEmployeesCollection from 'collections/PageableEmployeesCollection';
import PageableShiftsCollection from 'collections/PageableShiftsCollection';
import PageableJobsCollection from 'collections/PageableJobsCollection';
import ReportModel from 'models/ReportModel';
import MiniChooser from 'components/MiniChooser';
import DatePicker from 'components/DatePicker';
import ApplicationService from 'services/ApplicationService';
import AddsModelLoadingStateToActionSheet from 'views/mixins/AddsModelLoadingStateToActionSheet';
import SearchesCollection from 'views/mixins/SearchesCollection';
import {mixin, getFormData} from 'helpers';
import mdl from 'mdl';
import template from 'templates/reports/create.tpl';
import timesheet from 'templates/reports/parameters/timesheet.tpl';
import shift from 'templates/reports/parameters/shift.tpl';
import job from 'templates/reports/parameters/job.tpl';

/**
 * Form for creating a Timesheet Report
 */
const TimesheetParameterView = LayoutView.extend({
    template: timesheet,
    regions: {employeeChooser: '.employee-chooser-region'},
    ui: {
        startDate: '.js-date-start',
        endDate: '.js-date-end',
    },
    onBeforeShow() {
        this.collection = new PageableEmployeesCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            itemIcon: 'person',
            collection: this.collection,
        });
        this.showChildView('employeeChooser', this.chooser);
        this.collection.fetch();
        this.listenTo(this.chooser, 'selected', this.onEmployeeSelected);
    },
    onShow() {
        mdl.upgradeAllRegistered();
        new DatePicker({field: this.ui.startDate});
        new DatePicker({field: this.ui.endDate});
    },
    onEmployeeSelected(employee) {
        this.model.set('employee_id', employee.get('id'));
    }
});
mixin(TimesheetParameterView, SearchesCollection);

/**
 * Form for creating a Shift Report
 */
const ShiftParametersView = LayoutView.extend({
    template: shift,
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
        new DatePicker({field: this.ui.startDate});
        new DatePicker({field: this.ui.endDate});
    },
    onShiftSelected(shift) {
        this.model.set('job_shift_id', shift.get('id'));
    },
});
mixin(ShiftParametersView, SearchesCollection);

/**
 * Form for creating a Job Summary Report
 */
const JobParametersView = LayoutView.extend({
    template: job,
    regions: {jobChooser: '.job-chooser-region'},
    onBeforeShow() {
        this.collection = new PageableJobsCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            itemIcon: 'assignment',
            primaryField(model) {
                return '#' + model.get('number');
            },
            secondaryField: 'name',
            collection: this.collection,
        });
        this.showChildView('jobChooser', this.chooser);
        this.collection.fetch();
        this.listenTo(this.chooser, 'selected', this.onJobSelected);
    },
    onShow() {
        mdl.upgradeAllRegistered();
        new DatePicker({field: this.ui.startDate});
        new DatePicker({field: this.ui.endDate});
    },
    onJobSelected(job) {
        this.model.set('job_id', job.get('id'));
    },
});
mixin(JobParametersView, SearchesCollection);

/**
 * Map report types to parameter views.
 */
const ParameterViews = {
    timesheet: TimesheetParameterView,
    shift: ShiftParametersView,
    job: JobParametersView,
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
    onTypeChanged(e) {
        var type = $(e.currentTarget).val();
        this.showReportParametersForm(type);
    },
    showReportParametersForm(type) {
        var ViewClass = ParameterViews[type];

        this.showChildView('parameters', new ViewClass({
            model: this.model
        }));
    },
    createReport() {
        this.model.set(getFormData(this.ui.form));
        this.model.save().then(() => {
            this.actionSheet.close();
            ApplicationService.request('route', `/reports/${this.model.get('id')}`);
        });
    },
});

mixin(CreateReportView, AddsModelLoadingStateToActionSheet);

export default CreateReportView;
