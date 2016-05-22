import _ from 'lodash';
import nprogress from 'nprogress';
import {LayoutView} from 'backbone.marionette';
import api from 'core/Api';
import PageableEmployeesCollection from 'collections/PageableEmployeesCollection';
import TerminalService from 'services/TerminalService';
import AddEmployeeView from 'views/terminal/AddEmployeeView';
import ActionSheet from 'components/ActionSheet';
import Dialog from 'components/Dialog';
import FormValidator from 'components/FormValidator';
import MiniChooser from 'components/MiniChooser';
import template from 'templates/terminal/prompts/register-timecard.tpl';
import mdl from 'mdl';

const RegisterTimecardPromptView = LayoutView.extend({
    template,

    ui: {
        form: 'form',
        timecard: 'input[name=terminal_key]',
        search: 'input[name=search]',
        register: '.js-register',
    },

    events: {
        'click .js-cancel': 'cancel',
        'click @ui.register': 'onSubmit',
        'click .js-new-employee': 'showNewEmployeeActionSheet',
        'keyup @ui.search': 'handleSearchInput',
    },

    regions: {
        employeeSearch: '.employee-search-region'
    },

    cancel() {
        TerminalService.request('index');
    },

    initialize(options) {
        this.timecards = options.timecards;
    },

    onBeforeShow() {
        this.employees = new PageableEmployeesCollection();
        this.chooser = new MiniChooser({
            isFixedHeight: true,
            isScrollable: true,
            secondaryField: function(model) {
                return model.get('terminal_key') ? null : '(Unassigned)';
            },
            itemIcon: 'person',
            collection: this.employees,
        });
        this.showChildView('employeeSearch', this.chooser);
        this.employees.setSorting('created_at', 1);
        this.employees.fetch();
        this.listenTo(this.chooser, 'selected', this.onEmployeeSelected);
    },

    onShow() {
        mdl.upgradeAllRegistered();
        this.ui.timecard.focus();
        this.validator = new FormValidator({
            form: this.ui.form
        });
    },

    showNewEmployeeActionSheet() {
        this.sheet = new ActionSheet({
            view: new AddEmployeeView()
        });
        this.sheet.open();
    },

    onEmployeeSelected(employee) {
        this.selectedEmployee = employee;
        this.ui.register.attr('disabled', false);
    },

    onSubmit() {
        var existingTimecard = this.timecards.findWhere({terminal_key: this.ui.timecard.val()});

        if (existingTimecard && existingTimecard.get('id') !== this.selectedEmployee.get('id')) {
            Dialog.open({
                title: 'Reassign timecard?',
                body: 'This timecard is already registered to ' + existingTimecard.get('name')
                    + '. Are you sure you want to reassign this timecard to ' + this.selectedEmployee.get('name')
                    + '? <span class="dialog__body-subtext">' + existingTimecard.get('name') + ' will not be able to '
                    + 'clock in or out until you register another timecard for them.',
                primaryAction: 'Reassign'
            }).then(this.register.bind(this));
        } else {
            this.register();
        }
    },

    register() {
        nprogress.start();
        api.post('employees/%s/register', this.selectedEmployee.get('id'), {
            terminal_key: this.ui.timecard.val()
        }).then((response) => {
            nprogress.done();
            this.selectedEmployee.reset(response.data);
            TerminalService.request('index');
        }).catch((errors) => {
            nprogress.done();
            this.validator.showServerErrors(errors);
        });
    },

    handleSearchInput() {
        var val = this.ui.search.val();

        if (val.length < 1) {
            this.clearSearch();
            return;
        }

        this.search(val);
    },

    search(keyword) {
        // Just in case this gets called elsewhere, update the UI.
        this.ui.search.val(keyword);

        if (!this.doSearch) {
            this.doSearch = _.debounce((keyword) => {
                this.employees.search(keyword);
            }, 300, {trailing: true});
        }
        this.doSearch(keyword);
    },

    clearSearch() {
        this.ui.search.val('');
        this.employees.fetch();
    }
});

export default RegisterTimecardPromptView;
