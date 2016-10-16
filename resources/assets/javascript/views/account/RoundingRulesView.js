import {ItemView, LayoutView, CompositeView} from 'backbone.marionette';
import ActionSheet from 'components/ActionSheet';
import ManageRoundingRuleView from 'views/account/ManageRoundingRuleView';
import DisplaysMenu from 'views/mixins/DisplaysMenu';
import Dialog from 'components/Dialog';
import {mixin} from 'helpers';
import template from 'templates/account/rounding-rules.tpl';
import itemTemplate from 'templates/account/rounding-rules-item.tpl';
import emptyTemplate from 'templates/account/rounding-rules-empty.tpl';

const RoundingRuleItemView = LayoutView.extend({
    template: itemTemplate,
    tagName: 'tr',

    events: {
        'click .js-edit-rule': 'showEditRuleActionSheet'
    },

    modelEvents: {
        sync: 'render'
    },

    menuOptions: {
        items: [
            {key: 'edit', label: 'Edit'},
            {key: 'delete', label: 'Delete'},
        ],
    },

    templateHelpers() {
        let model = this.model;
        return {
            start: model.formatTime('start'),
            end: model.formatTime('end'),
            resolution: model.formatTime('resolution'),
            criteria() {
                let criteria = model.get('criteria').time;
                if (criteria === 'all') {
                    return 'All Time Entries';
                }
                if (criteria === 'clock_in') {
                    return 'Clock In Entries';
                }
                if (criteria === 'clock_out') {
                    return 'Clock Out Entries';
                }
            }
        };
    },

    onEditSelected() {
        let sheet = new ActionSheet({
            view: new ManageRoundingRuleView({
                model: this.model,
            })
        });
        sheet.open();
    },

    onDeleteSelected() {
        Dialog.open({
            title: 'Delete rounding rule?',
            body: 'This rounding rule will no longer apply to any reports. Are you sure you want to delete it?',
            primaryAction: 'Delete',
        }).done(() => this.model.destroy());
    }
});
mixin(RoundingRuleItemView, DisplaysMenu);

const RoundingRuleEmptyView = ItemView.extend({
    template: emptyTemplate,
    tagName: 'tr',
});

const RoundingRulesView = CompositeView.extend({
    template,
    childViewContainer: 'tbody',
    childView: RoundingRuleItemView,
    emptyView: RoundingRuleEmptyView,

    events: {
        'click .js-add-rule': 'showAddRuleActionSheet'
    },

    showAddRuleActionSheet() {
        let sheet = new ActionSheet({
            view: new ManageRoundingRuleView({
                collection: this.collection,
            })
        });
        sheet.open();
    }
});

export default RoundingRulesView;
