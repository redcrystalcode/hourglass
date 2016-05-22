import BaseCollection from 'collections/BaseCollection';
import LocationModel from 'models/LocationModel';
import {setUpDefaultSort} from 'helpers';

const LocationsCollection = BaseCollection.extend({
    url: '/locations',
    model: LocationModel,
    sortRules: {
        alpha: {attr: 'name', dir: -1, label: 'Alphabetical'},
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'alpha'
});

setUpDefaultSort(LocationsCollection);

export default LocationsCollection;
