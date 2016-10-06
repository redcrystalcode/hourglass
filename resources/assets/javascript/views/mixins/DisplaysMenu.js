import Menu from 'components/Menu';
import InvalidMixinUsageError from 'errors/InvalidMixinUsageError';
import Str from 'util/Str';
import {LayoutView} from 'backbone.marionette';
import _ from 'lodash';

const DisplaysMenu = {
    initialize() {
        if (!(this instanceof LayoutView)) {
            throw new InvalidMixinUsageError('DisplaysMenu', 'LayoutView');
        }

        this.menuOptions = _.result(this, 'menuOptions');

        if (this._isMenuDisabled()) {
            return;
        }
    },

    onShow() {
        this.onDomRefresh();
    },

    onDomRefresh() {
        if (this._isMenuDisabled()) {
            return;
        }

        this.menu = new Menu({
            items: _.result(this.menuOptions, 'items', []),
        });
        this.listenTo(this.menu, 'selected', this.onMenuSelection);
        this.addRegion('menuRegion', _.result(this.menuOptions, 'container', '.menu-container'));
        this.showChildView('menuRegion', this.menu);
    },

    onMenuSelection(selected) {
        if (this._isMenuDisabled()) {
            return;
        }

        if (_.result(this.menuOptions, 'triggerEvents', false)) {
            this.trigger('menu:' + selected.key);
            return;
        }

        if (selected.callback && _.isFunction(selected.callback)) {
            return selected.callback.apply(this, [selected]);
        }

        let method = _.isString(selected.callback)
            ? selected.callback
            : 'on' + Str.upperCamelCase(selected.key) + 'Selected';

        if (!_.isFunction(this[method])) {
            throw new Error(`this.${method} is not a function.`);
        }

        this[method]();
    },

    /**
     * @return {boolean}
     * @private
     */
    _isMenuDisabled() {
        return (this.menuOptions.disable === true) || (this.menuOptions.items.length === 0);
    }
};

export default DisplaysMenu;
