import PageableCollection from 'backbone.paginator';

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
        var pagination = response.meta.pagination;

        return {
            totalRecords: pagination.total,
            currentPage: pagination.current_page,
            pageSize: pagination.per_page,
            totalPages: pagination.total_pages
        };
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
        var end = this.getPageStart() + this.getPageSize() - 1;

        if (end > this.getTotalRecords()) {
            return this.getTotalRecords();
        }

        return end;
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
        this.trigger('search');
        this.fetch({data: {search: keyword}});
    }
});

export default BasePageableCollection;
