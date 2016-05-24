import BasePageableCollection from "collections/BasePageableCollection";
import AgencyModel from "models/AgencyModel";
import {setUpDefaultSort} from "helpers";

const PageableAgenciesCollection = BasePageableCollection.extend({
    url: '/agencies',
    model: AgencyModel,
    sortRules: {
        alpha: {attr: 'name', dir: -1, label: 'Alphabetical'},
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'alpha',
});

setUpDefaultSort(PageableAgenciesCollection);

export default PageableAgenciesCollection;
