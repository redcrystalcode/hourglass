import PageableCollection from 'backbone.paginator';
import _ from 'lodash';

/**
 * This is the "abstract" base collection for all
 * Hourglass collections. Do not use this directly.
 * @abstract
 */
const BasePageableCollection = PageableCollection.extend({
    state: {
        pageSize: 10, // default page size
    },
    queryParams: {
        totalPages: null,
        totalRecords: null,
    },
    parseRecords(response) {
        return response.data;
    },
    parseState(response) {
        let pagination = response.meta.pagination;

        return {
            totalRecords: pagination.total,
            currentPage: pagination.current_page,
            pageSize: pagination.per_page,
            totalPages: pagination.total_pages
        };
    },

    fetch(options) {
        options = options || {};
        options.data = _.extend({}, options.data ? _.extend(options.data, this.queryParams) : this.queryParams);
        return PageableCollection.prototype.fetch.call(this, options);
    },

    setSorting(sortKey, order, options) {
        let result = PageableCollection.prototype.setSorting.apply(this, arguments);
        this.trigger('pageable:state:change');
        return result;
    },

    /**
     * Get the current page of the collection.
     * @return {number}
     */
    getCurrentPage() {
        return this.state.currentPage;
    },

    /**
     * Get the total records in the collection.
     * @return {number}
     */
    getTotalRecords() {
        return this.state.totalRecords;
    },

    /**
     * Get the number of items on the page.
     * @return {number}
     */
    getPageSize() {
        return this.state.pageSize;
    },

    /**
     * Get the number of the first item on the page in the collection.
     * @return {number}
     */
    getPageStart() {
        return this.getPageSize() * (this.getCurrentPage() - 1) + 1;
    },

    /**
     * Get the number of the first item on the page in the collection.
     * @return {number}
     */
    getPageEnd() {
        let end = this.getPageStart() + this.getPageSize() - 1;

        if (end > this.getTotalRecords()) {
            return this.getTotalRecords();
        }

        return end;
    },

    /**
     * Get the current search keyword applied to this collection.
     * @returns {?string}
     */
    getSearchKeyword() {
        return this.queryParams ? this.queryParams.search : undefined;
    },

    /**
     * Get the current search keyword applied to this collection.
     * @returns {?string}
     */
    getSortState() {
        return _.findKey(this.sortRules, {attr: this.state.sortKey, dir: this.state.order});
    },

    getPreviousPage() {
        if (!this.hasPreviousPage()) {
            return;
        }
        this.trigger('page');
        this.trigger('page:previous');
        PageableCollection.prototype.getPreviousPage.apply(this, arguments);
    },

    getNextPage() {
        if (!this.hasNextPage()) {
            return;
        }
        this.trigger('page');
        this.trigger('page:next');
        PageableCollection.prototype.getNextPage.apply(this, arguments);
    },

    search(keyword) {
        if (!keyword) {
            delete this.queryParams.search;
        } else {
            this.queryParams.search = keyword;
        }
        this.trigger('search');
        this.trigger('pageable:state:change');
        this.getFirstPage();
    },

    /**
     * Ingest query params to configure the collection's state.
     *
     * @param {object} query
     * @param {string} query.search
     * @param {int} query.page
     * @param {string} query.sort
     */
    ingestQueryParameters(query) {
        if (!query) {
            return;
        }
        if (query.search) {
            this.queryParams.search = query.search;
        }
        if (query.page) {
            this.state.currentPage = query.page;
        }
        if (query.sort) {
            let rules = this.sortRules[query.sort];
            this.setSorting(rules.attr, rules.dir);
        }
    },
}, {
    /**
     * Create an instance with a predetermined state using query parameters.
     *
     * @param {object} query
     * @param {object} options
     * @returns {*}
     */
    fromQueryParameters(query, options = {}) {
        let collection = new this([], options);
        collection.ingestQueryParameters(query);
        return collection;
    },
});

export default BasePageableCollection;
