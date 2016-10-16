import QueryString from 'query-string';
import ApplicationService from 'services/ApplicationService';
import {history} from 'backbone';

const PushesCollectionState = {
    collectionEvents: {
        'pageable:state:change': '_pushCollectionState',
    },

    _pushCollectionState: function() {
        let route = history.getFragment().replace(history.getSearch(), '');
        let page = this.collection.getCurrentPage();
        let sort = this.collection.getSortState();
        let args = {
            search: this.collection.getSearchKeyword(),
            page: page === 1 ? undefined : page,
            sort: sort === this.collection.defaultSort ? undefined : sort,
        };

        let query = QueryString.stringify(args);

        ApplicationService.navigate(query ? `${route}?${query}` : route);
    },
};

export default PushesCollectionState;
