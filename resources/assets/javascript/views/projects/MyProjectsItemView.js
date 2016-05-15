import {LayoutView} from "backbone.marionette";
import DisplaysMenu from "views/mixins/DisplaysMenu";
import ActionSheet from "components/ActionSheet";
import Dialog from "components/Dialog";
import EditProjectView from "views/projects/EditProjectView";
import {mixin} from "helpers";
import template from "templates/projects/my-projects-item.tpl";

const MyProjectsItemView = LayoutView.extend({
    template,

    tagName: 'li',

    className: 'mdl-list__item mdl-list__item--two-line mdl-list__item--anchor',

    menuOptions: {
        items: [
            {key: 'edit', label: 'Edit'},
            {key: 'delete', label: 'Delete'},
        ]
    },

    templateHelpers() {
        var model = this.model;
        return {
            link: function() {
                let id = model.get('id');
                return `/projects/${id}/items`;
            }
        };
    },

    onEditSelected() {
        var sheet = new ActionSheet({
            view: new EditProjectView({model: this.model, collection: this.collection})
        });
        sheet.open();
    },

    onDeleteSelected() {
        Dialog.open({
            title: 'Delete this project?',
            body: 'Deleting a project is currently not reversible. Are you sure you want to delete this project?',
            primaryAction: 'Delete'
        }).done(() => {
            this.model.destroy();
            this.collection.fetch();
        });
    },
});

// Display and manage the menu.
mixin(MyProjectsItemView, DisplaysMenu);

export default MyProjectsItemView;
