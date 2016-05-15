import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import MemberItemView from 'views/account/MemberItemView';
import AddMemberView from 'views/account/AddMemberView';
// import InvitationsCollection from 'collections/InvitationsCollection';
// import MembersCollection from 'collections/MembersCollection';
import template from 'templates/account/members.tpl';

const AccountMembersView = LayoutView.extend({
    template,

    regions: {
        pending: '.pending-invitations-region',
        members: '.members-region'
    },

    events: {
        'click .js-add-member-button': 'showAddMemberActionSheet',
    },

    initialize() {
        this.invitations = new InvitationsCollection();
        this.members = new MembersCollection();
    },

    onBeforeShow() {
        this.showChildView('pending', new CollectionCard({
            collection: this.invitations,
            childView: MemberItemView,
            childViewOptions: {type: 'invitation'},
            emptyView: EmptyView.extend({
                icon: 'mail',
                heading: "No pending invitations.",
                subhead: 'Invite someone new to your team! Click "New Member" above.'
            }),
            title: 'Pending Invitations',
            actions: [],
            searchable: false,
            pageable: false,
        }));
        this.invitations.fetch();

        this.showChildView('members', new CollectionCard({
            collection: this.members,
            childView: MemberItemView,
            childViewOptions: {type: 'members'},
            emptyView: EmptyView.extend({
                icon: 'group_add',
                heading: "It's lonely here.",
                subhead: 'You have no members on your team. Why not invite a member?'
            }),
            title: 'Members'
        }));
        this.members.fetch();
    },

    showAddMemberActionSheet() {
        var sheet = new ActionSheet({
            view: new AddMemberView({collection: this.invitations})
        });
        sheet.open();
    }
});

export default AccountMembersView;
