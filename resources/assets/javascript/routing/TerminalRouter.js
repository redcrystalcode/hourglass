import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import TerminalService from 'services/TerminalService';

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
        // 'terminal/register-timecard': 'registerTimecard'
        // 'terminal/:id': 'overview',
        // 'terminal/:id/items': 'items',
    },

    index() {
        HeaderService.request('activate', 'terminal');
        TerminalService.request('index');
    },

    registerTimecard() {
        HeaderService.request('activate', 'terminal');
        TerminalService.request('register:timecard');
    },

});

export default TerminalRouter;
