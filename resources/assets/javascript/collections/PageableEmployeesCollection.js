import BasePageableCollection from 'collections/BasePageableCollection';
import EmployeeModel from 'models/EmployeeModel';
import {setUpDefaultSort} from 'helpers';

const PageableEmployeesCollection = BasePageableCollection.extend({
    url: '/employees',
    model: EmployeeModel,
    sortRules: {
        alpha: {attr: 'name', dir: -1, label: 'Alphabetical'},
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'new'
});

setUpDefaultSort(PageableEmployeesCollection);

export default PageableEmployeesCollection;
