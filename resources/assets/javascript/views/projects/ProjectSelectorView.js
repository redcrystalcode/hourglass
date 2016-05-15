import {LayoutView} from 'backbone.marionette';
import MyProjectsView from 'views/projects/MyProjectsView';
import template from 'templates/projects/project-selector.tpl';

const ProjectSelectorView = LayoutView.extend({
    template,

    regions: {
        myProjects: '.my-projects-region',
        otherProjects: '.other-projects-region',
    },

    onBeforeShow() {
        this.showChildView('myProjects', new MyProjectsView());
    },
});

export default ProjectSelectorView;
