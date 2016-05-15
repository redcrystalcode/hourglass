import BaseModel from 'models/BaseModel';

const EmployeeModel = BaseModel.extend({
    urlRoot: '/employees'
});

export default EmployeeModel;
