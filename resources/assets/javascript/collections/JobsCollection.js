import BasePageableCollection from 'collections/BasePageableCollection';
import JobModel from 'models/JobModel';
import {setUpDefaultSort} from 'helpers';

const JobsCollection = BasePageableCollection.extend({
    url: '/jobs',
    model: JobModel,
    sortRules: {
        alpha: {attr: 'name', dir: -1, label: 'Alphabetical'},
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'new'
});

setUpDefaultSort(JobsCollection);

export default JobsCollection;
