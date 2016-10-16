import {LayoutView, CompositeView, ItemView} from 'backbone.marionette';
import api from 'core/Api';
import Radio from 'backbone.radio';
import LoadingView from 'components/LoadingView';
import EmployeesCollection from 'collections/EmployeesCollection';
import template from 'templates/employees/groups/manage/manage.tpl';
// import header from 'templates/employees/groups/manage/manage-header.tpl';
import employeeListTemplate from 'templates/employees/groups/manage/employee-list.tpl';
import employeeItemTemplate from 'templates/employees/groups/manage/employee-item.tpl';

// const HeaderContentView = LayoutView.extend({
//     template: header,
// });

const EmployeeItemView = ItemView.extend({
    template: employeeItemTemplate,
    channel: Radio.channel('group:manage:selection'),
    tagName: 'li',
    className: 'mdl-list__item employee-item',
    modelEvents: {
        sync: 'render',
    },
    events: {
        'click .js-add-button': 'onEmployeeAddClicked',
        'click .js-remove-button': 'onEmployeeRemoveClicked',
    },
    templateHelpers() {
        return {
            is_add: this.options.action === 'add',
            is_remove: this.options.action === 'remove',
        };
    },
    onEmployeeAddClicked() {
        this.channel.trigger('employee:add', this.model);
    },
    onEmployeeRemoveClicked() {
        this.channel.trigger('employee:remove', this.model);
    },
});

const EmployeeCollectionView = CompositeView.extend({
    template: employeeListTemplate,
    tagName: 'ul',
    className: 'mdl-list',
    childView: EmployeeItemView,
    childViewContainer: '.list-region',
    childViewOptions() {
        return {
            action: this.options.action,
        };
    },
    templateHelpers() {
        return {
            action: this.options.action,
        };
    },
});

const ManageGroupView = LayoutView.extend({
    template,

    channel: Radio.channel('group:manage:selection'),

    regions: {
        selectedEmployeesRegion: '.js-selected-employees-region',
        availableEmployeesRegion: '.js-available-employees-region',
    },

    dialogOptions() {
        let model = this.model;
        return {
            title: '<strong>Manage Group</strong> | ' + model.get('name'),
            primaryAction: {action: 'close', label: 'Done'},
            // headerContentView: this.headerContentView,
        }
    },

    initialize() {
        this.selectedEmployeesCollection = this.model.employees;
        this.model.employees.comparator = function(a) {
              return a.get('name');
        };
        this.employeesCollection = new EmployeesCollection();
        this.employeesCollection.url = this.model.url() + '/employees/available';
        this.employeesCollection.comparator = function(a) {
            return a.get('name');
        };
        // this.headerContentView = new HeaderContentView({
        //     collection: this.employeesCollection
        // });

        this.listenTo(this.channel, {
            'employee:add': this.onEmployeeAddSelected,
            'employee:remove': this.onEmployeeRemoveSelected,
        });
    },

    onBeforeShow() {
        this.showChildView('selectedEmployeesRegion', new LoadingView());
        this.showChildView('availableEmployeesRegion', new LoadingView());

        // Load the collection then show the collection view.
        this.selectedEmployeesCollection.fetch().then(() => {
            this.showChildView('selectedEmployeesRegion', new EmployeeCollectionView({
                collection: this.selectedEmployeesCollection,
                action: 'remove'
            }));
        });

        // Load the collection then show the collection view.
        this.employeesCollection.fetch().then(() => {
            this.employeesCollection.reset(this.employeesCollection.filter((model) => {
                return !this.selectedEmployeesCollection.findWhere(model.toJSON());
            }));
            this.showChildView('availableEmployeesRegion', new EmployeeCollectionView({
                collection: this.employeesCollection,
                action: 'add',
            }));
        });
    },

    onEmployeeAddSelected(employee) {
        api.post('groups/%d/employees', [this.model.get('id')], {
            employee_id: employee.get('id'),
        }).then((response) => {
            employee.clear().set(response.data).trigger('sync');
        }).catch((e) => {
            console.error(e);
            this.selectedEmployeesCollection.remove(employee);
            this.employeesCollection.add(employee);
        });

        this.selectedEmployeesCollection.add(employee);
        this.employeesCollection.remove(employee);
    },

    onEmployeeRemoveSelected(employee) {
        api.delete('groups/%d/employees/%d', [
            this.model.get('id'),
            employee.get('id')
        ]).then((response) => {
            employee.clear().set(response.data).trigger('sync');
        }).catch((e) => {
            console.error(e);
            this.selectedEmployeesCollection.add(employee);
            this.employeesCollection.remove(employee);
        });

        employee.set('agency', null);
        this.employeesCollection.add(employee);
        this.selectedEmployeesCollection.remove(employee);
    },
});

export default ManageGroupView;
