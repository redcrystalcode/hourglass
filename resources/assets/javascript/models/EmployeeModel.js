import BaseModel from 'models/BaseModel';
import {softDeletes} from "helpers";

const EmployeeModel = BaseModel.extend({
    urlRoot: '/employees',

    getCleanTerminalKey() {
        let key = this.get('terminal_key');
        if (!key) {
            return key;
        }
        return key.replace(/[;?]/g, '');
    }
});

softDeletes(EmployeeModel);

export default EmployeeModel;
