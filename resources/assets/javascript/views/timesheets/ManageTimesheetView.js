import {LayoutView} from 'backbone.marionette';
import moment from 'moment';
import FormManager from 'components/FormManager';
import MiniChooser from 'components/MiniChooser';
import DatePicker from 'components/DatePicker';
import PageableEmployeesCollection from 'collections/PageableEmployeesCollection';
import PageableJobsCollection from 'collections/PageableJobsCollection';
import TimesheetModel from 'models/TimesheetModel';
import template from 'templates/timesheets/create.tpl';
import mdl from 'mdl';
import EmployeeModel from 'models/EmployeeModel';
import JobModel from 'models/JobModel';

const ManageTimesheetView = LayoutView.extend({
    template,
    actionSheetOptions() {
        let model = this.model;
        return {
            title: model.isNew() ? 'New Time Entry' : 'Edit Time Entry',
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
        employeeChooserRegion: '.employee-chooser-region',
        jobChooserRegion: '.job-chooser-region',
    },

    ui: {
        dateField: '.js-date-field',
    },

    templateHelpers() {
        let model = this.model;

        if (model.isNew()) {
            return {};
        }

        return {
            time_in: moment.utc(model.get('time_in')).local().format('h:mm A'),
            time_out: model.get('time_out') ? moment.utc(model.get('time_out')).local().format('h:mm A') : null,
            date: this.getDate(),
        };
    },
    initialize(options) {
        this.model = options.model || new TimesheetModel();
        this.employees = new PageableEmployeesCollection();
        this.jobs = new PageableJobsCollection();

        if (!this.model.isNew()) {
            this.model.set('employee_id', this.model.get('employee').id);
            this.model.set('job_id', this.model.get('job').id);
            this.model.set('date', this.getDate());
        }
    },
    getDate() {
        return moment.utc(this.model.get('time_in')).local().format('ddd, MMM D, Y');
    },
    onBeforeShow() {
        this.employeeChooser = new MiniChooser({
            showCreateField: false,
            searchable: true,
            isFixedHeight: true,
            isScrollable: true,
            itemIcon: 'person',
            collection: this.employees,
            selectedModel: this.model.get('employee') ? new EmployeeModel(this.model.get('employee')) : null,
            secondaryField(model) {
                if (model.get('terminal_key')) {
                    return `<span class="badge" title="Assigned Timecard">${model.getCleanTerminalKey()}</span>`
                }

                return `<span class="badge badge--gray">N/A</span>`
            },
        });
        this.showChildView('employeeChooserRegion', this.employeeChooser);
        this.employees.fetch();
        this.listenTo(this.employeeChooser, 'selected', this.onEmployeeSelected);

        this.jobChooser = new MiniChooser({
            showCreateField: false,
            searchable: true,
            isFixedHeight: true,
            isScrollable: true,
            itemIcon: 'work',
            primaryField(model) {
                return '#' + model.get('number');
            },
            secondaryField: 'name',
            selectedModel: this.model.get('job') ? new JobModel(this.model.get('job')) : null,
            collection: this.jobs,
        });
        this.showChildView('jobChooserRegion', this.jobChooser);
        this.jobs.fetch();
        this.listenTo(this.jobChooser, 'selected', this.onJobSelected);
    },
    onShow() {
        mdl.upgradeAllRegistered();
        new DatePicker({field: this.ui.dateField, maxDate: new Date()});

        this.formManager = new FormManager({
            form: this.$el.find('form'),
            model: this.model
        });
        this.listenTo(this.formManager, 'save:success', this.onSaveSuccess);
    },
    save() {
        this.formManager.submit();
    },
    onSaveSuccess() {
        if (this.options.collection) {
            this.options.collection.fetch();
        }
        this.close();
    },
    onEmployeeSelected(employee) {
        const id = employee ? employee.get('id') : null;
        this.model.set('employee_id', id);
    },
    onJobSelected(job) {
        const id = job ? job.get('id') : null;
        this.model.set('job_id', id);
    },
    close() {
        this.actionSheet.close();
    }
});

export default ManageTimesheetView;
