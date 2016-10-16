import _ from 'lodash';

const SearchesCollection = {
    ui: {
        search: '.js-collection-search'
    },
    events: {
        'keyup @ui.search': 'handleSearchInput'
    },
    handleSearchInput() {
        let val = this.ui.search.val();
        if (val.length < 1) {
            this.clearSearch();
            return;
        }
        this.search(val);
    },

    search(keyword) {
        // Just in case this gets called elsewhere, update the UI.
        this.ui.search.val(keyword);
        if (!this.doSearch) {
            this.doSearch = _.debounce((keyword) => {
                this.collection.search(keyword);
            }, 300, {trailing: true});
        }
        this.doSearch(keyword);
    },

    clearSearch() {
        this.ui.search.val('');
        this.collection.fetch();
    }
};

export default SearchesCollection;
