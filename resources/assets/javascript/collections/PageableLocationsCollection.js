import BasePageableCollection from 'collections/BasePageableCollection';
import LocationModel from 'models/LocationModel';
import {setUpDefaultSort} from 'helpers';

const PageableLocationsCollection = BasePageableCollection.extend({
    url: '/locations',
    model: LocationModel,
    sortRules: {
        alpha: {attr: 'name', dir: -1, label: 'Alphabetical'},
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'alpha',
});

setUpDefaultSort(PageableLocationsCollection);

export default PageableLocationsCollection;
