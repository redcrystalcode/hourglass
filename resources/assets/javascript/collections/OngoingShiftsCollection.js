import BaseCollection from 'collections/BaseCollection';
import JobShiftModel from 'models/JobShiftModel';
import {setUpDefaultSort} from 'helpers';

const OngoingShiftsCollection = BaseCollection.extend({
    url: '/terminal/shifts',
    model: JobShiftModel,
    sortRules: {
        alpha: {attr: 'name', dir: -1, label: 'Alphabetical'},
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'alpha'
});

setUpDefaultSort(OngoingShiftsCollection);

export default OngoingShiftsCollection;
