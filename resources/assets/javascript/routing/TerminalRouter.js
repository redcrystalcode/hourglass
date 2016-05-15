import BaseRouter from 'routing/BaseRouter';
import ItemsRoute from 'routing/routes/projects/ItemsRoute';
import HeaderService from 'services/HeaderService';
import ProjectSelectorView from 'views/projects/ProjectSelectorView';

const TerminalRouter = BaseRouter.extend({
    onInitialize() {
        HeaderService.request('add', {
            icon: 'computer',
            name: 'Terminal',
            path: 'terminal',
            type: 'primary'
        });
    },

    routes: {
        'terminal': 'index',
        // 'terminal/:id': 'overview',
        // 'terminal/:id/items': 'items',
    },

    index() {
        HeaderService.request('activate', 'projects');
        this.container.show(new ProjectSelectorView());
    },

    overview(id) {
        // TODO - Show project overview
        this.go(`projects/${id}/items`);
    },

    items(id) {
        HeaderService.request('activate', 'projects.items');
        return new ItemsRoute({
            container: this.container,
            projectId: id,
        });
    }

});

export default TerminalRouter;
