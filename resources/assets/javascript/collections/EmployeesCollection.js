import BaseCollection from 'collections/BaseCollection';
import EmployeeModel from 'models/EmployeeModel';

const EmployeesCollection = BaseCollection.extend({
    url: '/employees',
    model: EmployeeModel,
});


export default EmployeesCollection;
