import {CollectionView, ItemView} from 'backbone.marionette';
import _ from 'lodash';

const CollectionCardList = CollectionView.extend({
    className: 'mdl-list',

    tagName: 'ul',

    loaded: false,

    collectionEvents: {
        request: 'addLoadingState',
        sync: 'removeLoadingState',
        destroy: 'removeLoadingState',
    },

    initialize(options = {}) {
        this._emptyView = options.emptyView;
    },

    onRender() {
        // Set fixed height on the collection card list if pageable.
        if (this.options.pageable) {
            let size = this.collection.getPageSize();
            let itemHeight = (this.options.slim)
                ? CollectionCardList.ITEM_HEIGHT_SLIM
                : CollectionCardList.ITEM_HEIGHT_NORMAL;

            let height = (itemHeight * size); // each line is 72px by default.
            height += (size - 1); // to account for borders

            this.$el.css({'min-height': height})
        }
    },

    buildChildView(child, ChildViewClass, childViewOptions) {
        // Attach the collection to the childview.
        var options = _.extend({
            model: child,
            collection: this.collection
        }, childViewOptions);

        return new ChildViewClass(options);
    },

    getEmptyView() {
        return this._emptyView;
    },

    addLoadingState() {
        this._emptyView = ItemView.extend({template: false});
        if (!this.collection.length) {
            this.render();
        }
    },

    removeLoadingState() {
        this._emptyView = this.options.emptyView;

        if (!this.collection.length) {
            this.render();
        }
    }
}, {
    ITEM_HEIGHT_NORMAL: 72,
    ITEM_HEIGHT_SLIM: 56,
});

export default CollectionCardList;
