import BasePageableCollection from 'collections/BasePageableCollection';
import ReportModel from 'models/ReportModel';
import {setUpDefaultSort} from 'helpers';

const PageableReportsCollection = BasePageableCollection.extend({
    url: '/reports',
    model: ReportModel,
    sortRules: {
        alpha: {attr: 'name', dir: -1, label: 'Alphabetical'},
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'new',
});

setUpDefaultSort(PageableReportsCollection);

export default PageableReportsCollection;
