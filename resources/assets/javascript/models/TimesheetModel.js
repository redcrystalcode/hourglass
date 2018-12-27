import BaseModel from 'models/BaseModel';
import moment from "moment";

const TimesheetModel = BaseModel.extend({
    urlRoot: '/timesheets',
});

export default TimesheetModel;
