import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import DisplaysMenu from 'views/mixins/DisplaysMenu';
import ManageGroupView from 'views/employees/groups/ManageGroupView';
import {mixin} from 'helpers';
import template from 'templates/employees/groups/list.tpl';
import itemTemplate from 'templates/employees/groups/item.tpl';

const GroupItemView = LayoutView.extend({
    template: itemTemplate,
    tagName: 'li',
    className: 'mdl-list__item',

    menuOptions: {
        items: [
            {key: 'edit', label: 'Edit'},
        ],
    },

    modelEvents: {
        sync: 'render',
    },

    onEditSelected() {
        let sheet = new ActionSheet({
            view: new ManageGroupView({
                collection: this.model.collection,
                model: this.model,
            })
        });
        sheet.open();
    },
});

mixin(GroupItemView, DisplaysMenu);

const GroupsListView = LayoutView.extend({
    template,
    regions: {
        groups: '.js-groups-card-region'
    },
    events: {
        'click .js-add-group-button': 'showAddGroupActionSheet',
    },

    onBeforeShow() {
        this.showChildView('groups', new CollectionCard({
            collection: this.collection,
            childView: GroupItemView,
            emptyView: EmptyView.extend({
                icon: 'group',
                heading: 'There are no groups here.',
                subhead: 'Add groups to organize your employees.',
            }),
        }));
    },

    showAddGroupActionSheet() {
        let sheet = new ActionSheet({
            view: new ManageGroupView({collection: this.collection})
        });
        sheet.open();
    }
});

export default GroupsListView;
