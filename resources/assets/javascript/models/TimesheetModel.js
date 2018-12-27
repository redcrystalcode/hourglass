import BaseModel from 'models/BaseModel';
import moment from "moment";

const ReportModel = BaseModel.extend({
    urlRoot: '/timesheets',
});

export default ReportModel;
