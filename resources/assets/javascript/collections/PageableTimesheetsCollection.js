import BasePageableCollection from 'collections/BasePageableCollection';
import TimesheetModel from 'models/TimesheetModel';
import {setUpDefaultSort} from 'helpers';

const PageableTimesheetsCollection = BasePageableCollection.extend({
    url: '/timesheets',
    model: TimesheetModel,
    sortRules: {
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        time: {attr: 'time_in', dir: 1, label: 'Reverse Chronological'},
    },
    defaultSort: 'time',
});

setUpDefaultSort(PageableTimesheetsCollection);

export default PageableTimesheetsCollection;
