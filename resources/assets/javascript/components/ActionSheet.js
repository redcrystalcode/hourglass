import {LayoutView} from 'backbone.marionette';
import Overlay from 'components/Overlay';
import mdl from 'mdl';
import $ from 'jquery';
import _ from 'lodash';
import template from 'templates/components/action-sheet/layout.tpl';

const ActionSheet = LayoutView.extend({
    template,
    tagName: 'aside',
    className: 'action-sheet',
    regions: {
        body: '.action-sheet__body'
    },
    events: {
        'click .js-close-button': 'close',
        'click .js-primary-action': 'handlePrimaryAction',
        'click .js-secondary-action': 'handleSecondaryAction',
    },
    templateHelpers() {
        var self = this;
        return {
            title: self.title,
            primary_action: self.primaryAction,
            secondary_action: self.secondaryAction,
            has_footer() {
                return self.primaryAction || self.secondaryAction;
            }
        };
    },
    actionSheetOptions: [
        'title', 'primaryAction', 'secondaryAction'
    ],
    initialize(options = {}) {
        this.view = options.view;
        this.mergeOptions(
            _.result(this.view, 'actionSheetOptions', {}),
            this.actionSheetOptions
        );
        this.view.actionSheet = this;
    },
    onShow() {
        if (this.view) {
            this.showChildView('body', this.view);
        }
        mdl.upgradeAllRegistered();
    },
    open() {
        this.render();
        this.overlay = new Overlay();
        this.overlay.open();
        $('body').append(this.$el);
        this.$el.addClass('action-sheet--visible');
        this.onShow();
        this.listenTo(this.overlay, 'close', this.close);
    },
    close() {
        this.trigger('before:close');
        if (this.view) {
            _.result(this.view, 'onBeforeActionSheetClose');
        }
        this.overlay.close();
        this.$el.removeClass('action-sheet--visible')
            .addClass('action-sheet--hiding')
            .on('animationend', () => {
                this.$el.remove();
                this.trigger('close');
                this.destroy();
            });
    },
    setLoadingState(loading = true) {
        if (loading) {
            this.$el.addClass('action-sheet--loading');
        } else {
            this.$el.removeClass('action-sheet--loading');
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
        var view = this.view;

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

export default ActionSheet;
