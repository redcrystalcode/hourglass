import _ from 'lodash';
import {Collection} from 'backbone';
import {LayoutView} from 'backbone.marionette';
import PageableEmployeesCollection from 'collections/PageableEmployeesCollection';
import TerminalService from 'services/TerminalService';
import AddEmployeeView from 'views/terminal/AddEmployeeView';
import ActionSheet from 'components/ActionSheet';
import MiniChooser from 'components/MiniChooser';
import template from 'templates/terminal/prompts/register-timecard.tpl';
import mdl from 'mdl';

const RegisterTimecardPromptView = LayoutView.extend({
    template,

    ui: {
        input: 'input[name=timecard]',
        search: 'input[name=search]'
    },

    events: {
        'click .js-cancel': 'cancel',
        'click .js-new-employee': 'showNewEmployeeActionSheet',
        'keyup @ui.search': 'handleSearchInput',
    },

    regions: {
        employeeSearch: '.employee-search-region'
    },

    cancel() {
        TerminalService.request('index');
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
        this.employees.fetch();
        this.listenTo(this.chooser, 'selected', this.onEmployeeSelected);
    },

    onShow() {
        mdl.upgradeAllRegistered();
        this.ui.input.focus();
    },

    showNewEmployeeActionSheet() {
        this.sheet = new ActionSheet({
            view: new AddEmployeeView()
        });
        this.sheet.open();
    },

    onEmployeeSelected(employee) {
        console.log('Selected!');
        console.log(employee);
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
