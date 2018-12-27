import _ from 'lodash';
import {ItemView, CompositeView} from 'backbone.marionette';
import {mixin} from 'helpers';
import layout from 'templates/components/mini-chooser/layout.tpl';
import item from 'templates/components/mini-chooser/item.tpl';
import SearchesCollection from "views/mixins/SearchesCollection";

function getModelAttribute(model, attribute) {
    if (typeof attribute === 'string') {
        return model.get(attribute);
    }
    if (typeof attribute === 'function') {
        return attribute(model);
    }
    return null;
}

function stripTags(value) {
    const tmp = document.createElement("DIV");
    tmp.innerHTML = value;
    return tmp.textContent || tmp.innerText || "";
}

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
        let view = this;
        return {
            icon: this.model.get('icon') || this.options.icon,
            primary() {
                return getModelAttribute(view.model, view.options.primaryField);
            },
            secondary() {
                return getModelAttribute(view.model, view.options.secondaryField);
            },
            secondary_clean() {
                const value = getModelAttribute(view.model, view.options.secondaryField);
                return stripTags(value);
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
    ui: {
        selected: '.mini-chooser__selected',
    },
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
    searchable: false,
    selectedModel: null,
    miniChooserOptions: [
        'showCreateField', 'itemIcon', 'isScrollable', 'isFixedHeight',
        'primaryField', 'secondaryField', 'searchable', 'selectedModel',
    ],
    templateHelpers() {
        return {
            show_create_field: this.showCreateField,
            is_fixed_height: this.isFixedHeight,
            is_scrollable: this.isScrollable,
            searchable: this.searchable,
            icon: this.itemIcon,
            selected_model: this.selectedModel,
            primary: this.selectedModel && getModelAttribute(this.selectedModel, this.primaryField),
            secondary: this.selectedModel && getModelAttribute(this.selectedModel, this.secondaryField),
            secondary_clean: this.selectedModel && stripTags(getModelAttribute(this.selectedModel, this.secondaryField)),
        };
    },
    initialize(options) {
        this.mergeOptions(options, this.miniChooserOptions);
        this.uniqueId = _.uniqueId();
    },
    onItemSelected(child) {
        let currentSelection = this.collection.findWhere({selected: true});
        this.collection.invoke('set', {selected: false});

        // Deselect if selecting the same one.
        if (child.model === currentSelection) {
            this.trigger('selected', null);
            this.toggleOriginalSelectionDisplay(true);
            return;
        }

        this.trigger('selected', child.model);
        child.model.set('selected', true);
        this.toggleOriginalSelectionDisplay(false);
    },
    onRequest() {
        this.setLoadingState(true);
    },
    onSync() {
        this.setLoadingState(false);
    },
    toggleOriginalSelectionDisplay(show) {
        if (this.ui.selected.length) {
            this.ui.selected.toggle(show);
        }
    },
    setLoadingState(loading = true) {
        if (loading) {
            this.$el.addClass('mini-chooser--loading');
        } else {
            this.$el.removeClass('mini-chooser--loading');
        }
    }
});

mixin(MiniChooser, SearchesCollection);

export default MiniChooser;
