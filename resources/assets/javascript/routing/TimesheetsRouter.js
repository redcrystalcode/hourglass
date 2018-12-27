import BaseRouter from 'routing/BaseRouter';
import HeaderService from 'services/HeaderService';
import IndexRoute from 'routing/routes/timesheets/IndexRoute';

const TimesheetsRouter = BaseRouter.extend({
    onInitialize() {
        HeaderService.request('add', {
            icon: 'timer',
            name: 'Timesheets',
            path: 'timesheets',
            type: 'primary'
        });
    },

    routes: {
        'timesheets': 'timesheets',
    },

    timesheets(query) {
        HeaderService.request('activate', 'timesheets');
        return new IndexRoute({
            query,
            container: this.container,
        });
    },
});

export default TimesheetsRouter;
