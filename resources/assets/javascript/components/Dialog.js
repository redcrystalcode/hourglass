import {LayoutView} from 'backbone.marionette';
import Overlay from 'components/Overlay';
import mdl from 'mdl';
import $ from 'jquery';
import _ from 'lodash';
import template from 'templates/components/dialog.tpl';

const Dialog = LayoutView.extend({
    template,
    className: 'dialog',
    regions: {
        body: '.dialog__body',
        headerContent: '.header__content',
    },
    events: {
        'click .js-close-button': 'close',
        'click .js-primary-action': 'handlePrimaryAction',
        'click .js-secondary-action': 'handleSecondaryAction',
    },
    templateHelpers() {
        let self = this;
        return {
            title: self.title,
            primary_action: self.primaryAction,
            secondary_action: self.secondaryAction,
            has_footer() {
                return self.primaryAction || self.secondaryAction;
            }
        };
    },
    dialogOptions: [
        'title', 'primaryAction', 'secondaryAction', 'headerContentView',
    ],
    initialize(options = {}) {
        this.view = options.view;
        this.mergeOptions(
            _.result(this.view, 'dialogOptions', {}),
            this.dialogOptions
        );
        if (this.view) {
            this.view.dialog = this;
        }
        if (this.headerContentView) {
            this.headerContentView.dialog = this;
        }
    },
    onShow() {
        if (this.view) {
            this.showChildView('body', this.view);
        }
        if (this.headerContentView) {
            this.showChildView('headerContent', this.headerContentView);
        }
        mdl.upgradeAllRegistered();
    },
    open() {
        this.render();
        this.overlay = new Overlay();
        this.overlay.open();
        $('body').append(this.$el);
        this.$el.addClass('dialog--visible');
        this.onShow();
        this.listenTo(this.overlay, 'close', this.close);
    },
    close() {
        this.trigger('before:close');
        if (this.view) {
            _.result(this.view, 'onBeforeDialogClose');
        }
        this.overlay.close();
        this.$el.removeClass('dialog--visible')
            .addClass('dialog--hiding')
            .on('animationend', () => {
                this.$el.remove();
                this.trigger('close');
                this.destroy();
            });
    },
    setLoadingState(loading = true) {
        if (loading) {
            this.$el.addClass('dialog--loading');
        } else {
            this.$el.removeClass('dialog--loading');
        }
    },
    handlePrimaryAction() {
        if (!this.primaryAction) {
            return;
        }
        this.handleAction(this.primaryAction.action);
    },
    handleSecondaryAction() {
        if (!this.secondaryAction) {
            return;
        }
        this.handleAction(this.secondaryAction.action);
    },
    handleAction(action) {
        if (!action) {
            return;
        }
        let view = this.view;

        if (action === 'close') {
            this.close();
            return;
        }

        if (_.isFunction(action)) {
            action.call(view);
            return;
        }

        if (_.isFunction(view[action])) {
            view[action]();
        }
    }
});

export default Dialog;
