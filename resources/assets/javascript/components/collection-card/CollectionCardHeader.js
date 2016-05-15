import {LayoutView} from 'backbone.marionette';
import SortButton from 'components/SortButton';
import _ from 'lodash';
import template from 'templates/components/collection-card/header.tpl';

const CollectionCardHeader = LayoutView.extend({
    template,

    tagName: 'header',

    className: 'collection-card__header',

    ui: {
        search: 'input[name=search]',
        searchClearButton: '.search__clear',
    },

    events: {
        'keyup @ui.search': 'handleSearchInput',
        'click @ui.searchClearButton': 'clearSearch',
    },

    regions: {
        sortButtonRegion: '.sort-button',
    },

    templateHelpers() {
        return {
            title: this.options.title,
            show_sort_button: _.contains(this.options.actions, 'sort'),
            actions: this.options.actions.length > 0,
            searchable: this.options.searchable
        };
    },

    onBeforeShow() {
        if (_.contains(this.options.actions, 'sort')) {
            this.showChildView('sortButtonRegion', new SortButton({
                collection: this.collection
            }));
        }
    },

    handleSearchInput() {
        var val = this.ui.search.val();

        if (val.length < 1) {
            this.clearSearch();
            return;
        }

        this.ui.searchClearButton.addClass('search__clear--visible');
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
        this.ui.searchClearButton.removeClass('search__clear--visible');
        this.ui.search.val('');
        this.collection.fetch();
    }
});

export default CollectionCardHeader;
