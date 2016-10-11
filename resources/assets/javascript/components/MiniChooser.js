import _ from 'lodash';
import {ItemView, CompositeView} from 'backbone.marionette';
import layout from 'templates/components/mini-chooser/layout.tpl';
import item from 'templates/components/mini-chooser/item.tpl';

const MiniChooserItemView = ItemView.extend({
    template: item,
    className: 'mini-chooser__list-item',
    triggers: {
        click: 'item:selected',
    },
    modelEvents: {
        'change:selected': 'render'
    },
    templateHelpers() {
        var view = this;
        return {
            icon: this.model.get('icon') || this.options.icon,
            primary() {
                return view.getModelAttribute(view.options.primaryField);
            },
            secondary() {
                return view.getModelAttribute(view.options.secondaryField);
            },
        };
    },
    onRender() {
        this.$el.toggleClass('mini-chooser__list-item--selected', this.model.get('selected') === true);
    },
    getModelAttribute(attribute) {
        if (typeof attribute === 'string') {
            return this.model.get(attribute);
        }
        if (typeof attribute === 'function') {
            return attribute(this.model);
        }
        return null;
    },
});
const MiniChooser = CompositeView.extend({
    template: layout,
    className: 'mini-chooser',
    childView: MiniChooserItemView,
    childViewContainer: '.mini-chooser__list',
    childViewOptions() {
        return {
            icon: this.itemIcon,
            primaryField: this.primaryField,
            secondaryField: this.secondaryField,
        };
    },
    childEvents: {
        'item:selected': 'onItemSelected'
    },
    collectionEvents: {
        request: 'onRequest',
        sync: 'onSync',
    },
    showCreateField: false,
    isFixedHeight: false,
    isScrollable: false,
    itemIcon: null,
    primaryField: 'name',
    secondaryField: null,
    miniChooserOptions: [
        'showCreateField', 'itemIcon', 'isScrollable', 'isFixedHeight',
        'primaryField', 'secondaryField'
    ],
    templateHelpers() {
        return {
            show_create_field: this.showCreateField,
            is_fixed_height: this.isFixedHeight,
            is_scrollable: this.isScrollable,
        };
    },
    initialize(options) {
        this.mergeOptions(options, this.miniChooserOptions);
        this.uniqueId = _.uniqueId();
    },
    onItemSelected(child) {
        this.collection.invoke('set', {selected: false});
        child.model.set('selected', true);
        this.trigger('selected', child.model);
        // this.render();
    },
    onRequest() {
        this.setLoadingState(true);
    },
    onSync() {
        this.setLoadingState(false);
    },
    setLoadingState(loading = true) {
        if (loading) {
            this.$el.addClass('mini-chooser--loading');
        } else {
            this.$el.removeClass('mini-chooser--loading');
        }
    }
});

export default MiniChooser;
