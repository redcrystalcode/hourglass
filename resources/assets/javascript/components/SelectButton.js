import Menu from 'components/Menu';
import mdl from 'mdl';
import template from 'templates/components/select-button.tpl';

const SelectButton = Menu.extend({
    template,

    initialize(options) {
        Menu.prototype.initialize.call(this, options);
        this.defaultSelection = options.defaultSelection;
        this.model = this.collection.at(this.defaultSelection);
    },

    handleSelection(childView) {
        this.model = childView.model;
        this.trigger('selected', this.model.toJSON());
        this.render();
        this.onSelected();
    },

    onDomRefresh() {
        mdl.upgradeAllRegistered();
    },

    reset() {
        this.model = this.collection.at(this.defaultSelection);
        this.render();
        this.onReset();
    },

    /**
     * Use this method when extending this class to do something after reset.
     */
    onReset() {},

    /**
     * Use this method when extending this class to do something after selection.
     */
    onSelected() {},
});

export default SelectButton;
