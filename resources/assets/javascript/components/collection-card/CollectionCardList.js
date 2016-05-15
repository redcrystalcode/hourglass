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
});

export default CollectionCardList;
