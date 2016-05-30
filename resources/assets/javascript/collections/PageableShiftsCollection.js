import BasePageableCollection from 'collections/BasePageableCollection';
import JobShiftModel from 'models/JobShiftModel';
import {setUpDefaultSort} from 'helpers';

const PageableShiftsCollection = BasePageableCollection.extend({
    url: '/shifts',
    model: JobShiftModel,
    sortRules: {
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'new',
});

setUpDefaultSort(PageableShiftsCollection);

export default PageableShiftsCollection;
