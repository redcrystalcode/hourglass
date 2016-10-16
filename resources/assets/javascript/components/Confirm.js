import {ItemView} from 'backbone.marionette';
import mdl from 'mdl';
import $ from 'jquery';
import Overlay from 'components/Overlay';
import template from 'templates/components/confirm.tpl';

/**
 * Confirm Component.
 * @constructor
 * @param {Object} options
 * @param {string} options.title
 * @param {string} options.body
 * @param {Object[]} options.actions
 * @param {string} options.actions[].key
 * @param {string} options.actions[].label
 */
const Confirm = ItemView.extend({
    template,

    className: 'confirm',

    events: {
        'click .js-primary-action': 'handlePrimaryAction',
        'click .js-secondary-action': 'handleSecondaryAction',
    },

    templateHelpers() {
        let self = this;
        return {
            title: self.title,
            body: self.body,
            primaryAction: self.primaryAction,
            secondaryAction: self.secondaryAction,
        };
    },

    primaryAction: 'OK',

    secondaryAction: 'Cancel',

    confirmOptions: [
        'title', 'body', 'primaryAction', 'secondaryAction'
    ],

    initialize(options = {}) {
        this.mergeOptions(
            options,
            this.confirmOptions
        );
        this.deferred = $.Deferred();
    },

    onShow() {
        mdl.upgradeAllRegistered();
    },

    open() {
        this.render();
        this.overlay = new Overlay();
        this.overlay.open();
        $('body').append(this.$el);
        this.$el.addClass('confirm--visible');
        this.onShow();
        this.listenTo(this.overlay, 'close', this.close);
    },

    close() {
        if (this.deferred.state() === 'pending') {
            this.deferred.reject();
        }
        this.trigger('before:close');
        this.overlay.close();
        this.$el.removeClass('confirm--visible')
            .addClass('confirm--hiding')
            .on('animationend', () => {
                this.$el.remove();
                this.trigger('close');
                this.destroy();
            });
    },

    handlePrimaryAction() {
        this.deferred.resolve();
        this.close();
    },

    handleSecondaryAction() {
        this.deferred.reject();
        this.close();
    },

    /**
     * Get the promise.
     * @return {jQuery.Deferred} - Returns a Deferred object.
     */
    getPromise() {
        return this.deferred;
    }
});

/**
 * Open a confirm.
 * @param {Object} options
 * @param {string} options.title
 * @param {string} options.body
 * @param {string} options.primaryAction
 * @param {string} options.secondaryAction
 *
 * @return {jQuery.Deferred}
 */
Confirm.confirm = function(options) {
    let confirm = new Confirm(options);
    confirm.open();

    return confirm.getPromise();
};

export default Confirm;
