import BaseModel from 'models/BaseModel';
import EmployeesCollection from 'collections/EmployeesCollection';

const GroupModel = BaseModel.extend({
    urlRoot: '/groups',

    initialize() {
        this.employees = new EmployeesCollection();
        this.employees.url = '/groups/' + this.get('id') + '/employees';
    },
});

export default GroupModel;
