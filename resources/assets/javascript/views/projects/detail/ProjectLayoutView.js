import {LayoutView} from 'backbone.marionette';
import ProjectHeaderView from 'views/projects/detail/ProjectHeaderView';
// import AccountDetailsView from 'views/account/AccountDetailsView';
// import AccountMembersView from 'views/account/AccountMembersView';
import template from 'templates/projects/detail/layout.tpl';

const ProjectLayoutView = LayoutView.extend({
    template,

    regions: {
        hero: '.project-header-region',
        details: '.project-content-region',
    },

    onBeforeShow() {
        this.showChildView('hero', new ProjectHeaderView({
            model: this.model
        }));
        // this.showChildView('details', new AccountDetailsView({
        //     model: this.model
        // }));
        // this.showChildView('members', new AccountMembersView({
        //     model: this.model
        // }));
    },
});

export default ProjectLayoutView;
