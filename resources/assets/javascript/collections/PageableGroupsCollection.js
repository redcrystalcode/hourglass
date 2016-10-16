import BasePageableCollection from "collections/BasePageableCollection";
import GroupModel from "models/GroupModel";
import {setUpDefaultSort} from "helpers";

const PageableGroupsCollection = BasePageableCollection.extend({
    url: '/groups',
    model: GroupModel,
    sortRules: {
        alpha: {attr: 'name', dir: -1, label: 'Alphabetical'},
        new: {attr: 'created_at', dir: 1, label: 'Newest First'},
        old: {attr: 'created_at', dir: -1, label: 'Oldest First'},
    },
    defaultSort: 'alpha',
});

setUpDefaultSort(PageableGroupsCollection);

export default PageableGroupsCollection;
