import {LayoutView} from 'backbone.marionette';
import CollectionCard from 'components/collection-card/CollectionCard';
import EmptyView from 'components/EmptyView';
import ActionSheet from 'components/ActionSheet';
import MyProjectsItemView from 'views/projects/MyProjectsItemView';
import EditProjectView from 'views/projects/EditProjectView';
// import ProjectsCollection from 'collections/ProjectsCollection';
import template from 'templates/projects/my-projects.tpl';

const MyProjectsView = LayoutView.extend({
    template,

    regions: {
        card: '.collection-card-region'
    },

    events: {
        'click .js-add-project-button': 'showNewProjectActionSheet',
    },

    initialize() {
        // this.collection = new ProjectsCollection();
    },

    onBeforeShow() {
        this.showChildView('card', new CollectionCard({
            collection: this.collection,
            childView: MyProjectsItemView,
            emptyView: EmptyView.extend({
                icon: 'work',
                heading: "Looks like you don't have any projects yet.",
                subhead: 'Create a new project to get started!'
            })
        }));
        this.collection.fetch();
    },

    showNewProjectActionSheet() {
        var sheet = new ActionSheet({
            view: new EditProjectView({collection: this.collection})
        });
        sheet.open();
    },
});

export default MyProjectsView;
