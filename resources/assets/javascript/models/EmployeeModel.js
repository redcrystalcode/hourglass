import BaseModel from 'models/BaseModel';
import {softDeletes} from "helpers";

const EmployeeModel = BaseModel.extend({
    urlRoot: '/employees'
});

softDeletes(EmployeeModel);

export default EmployeeModel;
