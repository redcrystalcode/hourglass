import {Collection} from 'backbone';
import {CompositeView, ItemView} from 'backbone.marionette';
import mdl from 'mdl';
import template from 'templates/components/menu.tpl';
import _ from 'lodash';

/**
 * Create and manage a menu.
 * @constructor
 * @param {Object} options
 * @param {Object[]} options.items - The items in the menu.
 * @param {string} options.items[].key - The key representing an item in the menu.
 * @param {string} options.items[].label - The display text for an item in the menu.
 * @param {string} options.icon - The icon for the button to open the menu.
 */
const Menu = CompositeView.extend({
    template,

    childView: ItemView.extend({
        template: _.template('<%= label %>'),
        className: 'mdl-menu__item',
        tagName: 'li',
        triggers: {
            click: 'selected'
        },
    }),

    childViewContainer: '.mdl-menu',

    childEvents: {
        selected: 'handleSelection'
    },

    templateHelpers() {
        let view = this;
        return {
            icon: view.icon,
            buttonId: view.buttonId,
        };
    },

    initialize(options) {
        this.collection = new Collection(options.items);
        this.icon = options.icon || 'more_vert';
        this.buttonId = this.getButtonId();
    },

    onAttach() {
        mdl.upgradeAllRegistered();
    },

    handleSelection(childView) {
        this.trigger('selected', childView.model.toJSON());
        this.onSelected();
    },

    getButtonId() {
        return _.uniqueId('menu-button-');
    },

    /**
     * Use this method when extending this class to do something after selection.
     * @abstract
     */
    onSelected() {},
});

export default Menu;
