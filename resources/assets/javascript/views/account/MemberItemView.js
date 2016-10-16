import {LayoutView} from 'backbone.marionette';
import UserManager from 'managers/UserManager';
import DisplaysMenu from 'views/mixins/DisplaysMenu';
import Str from 'util/Str';
import {mixin} from 'helpers';
import Confirm from 'components/Confirm';;
import template from 'templates/account/member-item.tpl';

const MemberItemView = LayoutView.extend({
    template,

    tagName: 'li',

    className: 'mdl-list__item mdl-list__item--two-line',

    events: {
        'click .js-revoke-invitation': 'revokeInvitation'
    },

    menuOptions() {
        if (this.isInvitation()) {
            return {disable: true};
        }
        return {
            items: [
                {key: 'edit', label: 'Edit'},
                {key: 'delete', label: 'Delete'},
            ],
        };
    },

    templateHelpers() {
        return {
            role: () => {
                return this.getRole();
            },
            is_self: () => {
                return this.isSelf();
            },
            is_invitation: () => {
                return this.isInvitation();
            }
        };
    },

    getRole() {
        return Str.capitalize(this.model.get('role'));
    },

    isSelf() {
        let self = UserManager.getUser();
        return (self.get('id') === this.model.get('id'));
    },

    isInvitation() {
        return this.options.type === 'invitation';
    },

    revokeInvitation() {
        Confirm.confirm({
            title: 'Revoke invitation?',
            body: "This member won't be able to sign up to your account unless you send them another invitation.",
            primaryAction: 'Revoke',
        }).done(() => this.model.destroy());
    }
});

// Display and manage the menu.
mixin(MemberItemView, DisplaysMenu);

export default MemberItemView;
