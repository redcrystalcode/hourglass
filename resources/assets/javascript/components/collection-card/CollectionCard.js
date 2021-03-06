import {LayoutView} from 'backbone.marionette';
import _ from 'lodash';
import LoadingService from 'services/LoadingService';
import CollectionCardHeader from 'components/collection-card/CollectionCardHeader';
import CollectionCardList from 'components/collection-card/CollectionCardList';
import CollectionCardFooter from 'components/collection-card/CollectionCardFooter';
import smoothScroll from 'smoothscroll';
import template from 'templates/components/collection-card/card.tpl';

const CollectionCard = LayoutView.extend({
    template,

    className() {
        let classes = ['collection-card'];
        if (_.get(this.options, 'slim', false)) {
            classes.push('collection-card--slim');
        }
        return classes.join(' ');
    },

    regions: {
        list: '.collection-card__content',
        header: '.collection-card__header-wrapper',
        footer: '.collection-card__footer',
        loader: '.collection-card__loader',
    },

    ui: {
        search: '.header__search input[name=search]',
        searchClearButton: '.search__clear'
    },

    events: {
        'keyup @ui.search': 'handleSearchInput',
        'click @ui.searchClearButton': 'clearSearch',
    },

    collectionEvents: {
        page: 'handlePaging',
        request: 'addLoadingState',
        sync: 'removeLoadingState',
        error: 'removeLoadingState',
        destroy: 'removeLoadingState',
    },

    templateHelpers() {
        return {
            pageable: _.get(this.options, 'pageable', true),
            slim: _.get(this.options, 'slim', false),
        };
    },

    onBeforeShow() {
        this.showChildView('list', new CollectionCardList({
            collection: this.collection,
            childView: this.options.childView,
            childViewOptions: this.options.childViewOptions,
            emptyView: this.options.emptyView,
            pageable: _.get(this.options, 'pageable', true),
            slim: _.get(this.options, 'slim', false),
        }));
        if (_.get(this.options, 'pageable', true)) {
            this.showChildView('footer', new CollectionCardFooter({
                collection: this.collection
            }));
        }
        if (_.get(this.options, 'showHeader', true)) {
            this.showChildView('header', new CollectionCardHeader({
                collection: this.collection,
                title: this.options.title,
                actions: _.get(this.options, 'actions', ['sort']),
                searchable: _.get(this.options, 'searchable', true)
            }));
        }
    },

    handlePaging() {
        // Scroll to the top of the page.
        smoothScroll(this.$el[0]);
    },

    addLoadingState() {
        this.$el.addClass('collection-card--fetching');
        LoadingService.request('start', this.loader);
    },

    removeLoadingState() {
        this.$el.removeClass('collection-card--fetching');
        LoadingService.request('stop', this.loader);
    }
});

export default CollectionCard;
