import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import ApplicationService from 'services/ApplicationService';
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
        terminal: 'index',
    },

    index() {
        HeaderService.request('activate', 'terminal');
        ApplicationService.request('sidebar:show');
        TerminalService.request('index');
    }
});

export default TerminalRouter;
