import BaseModel from 'models/BaseModel';
import {softDeletes} from "helpers";

const JobModel = BaseModel.extend({
    urlRoot: '/jobs'
});

softDeletes(JobModel);

export default JobModel;
