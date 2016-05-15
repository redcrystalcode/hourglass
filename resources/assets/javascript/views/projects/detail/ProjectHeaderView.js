import {ItemView} from 'backbone.marionette';
import template from 'templates/projects/detail/header.tpl';

const ProjectHeaderView = ItemView.extend({
    template,

    modelEvents: {
        sync: 'render'
    },
});

export default ProjectHeaderView;
