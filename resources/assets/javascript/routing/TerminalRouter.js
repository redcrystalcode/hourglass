import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import TerminalLayoutView from 'views/terminal/TerminalLayoutView';

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
        HeaderService.request('activate', 'terminal');
        this.container.show(new TerminalLayoutView());
    },

});

export default TerminalRouter;
