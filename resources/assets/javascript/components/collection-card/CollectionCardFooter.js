import Marionette from 'backbone.marionette';
import template from 'templates/components/collection-card/footer.tpl';

const CollectionCardFooter = Marionette.ItemView.extend({
    template,

    className: 'footer__pagination',

    collectionEvents: {
        sync: 'render',
    },

    events: {
        'click .js-page-prev': 'previousPage',
        'click .js-page-next': 'nextPage',
    },

    templateHelpers() {
        var collection = this.collection;
        return {
            pagination: {
                total: collection.getTotalRecords(),
                start: collection.getPageStart(),
                end: collection.getPageEnd(),
                enable_prev: collection.hasPreviousPage(),
                enable_next: collection.hasNextPage(),
            }
        };
    },

    previousPage(e) {
        e.preventDefault();
        this.collection.getPreviousPage();
    },

    nextPage(e) {
        e.preventDefault();
        this.collection.getNextPage();
    }
});

export default CollectionCardFooter;
