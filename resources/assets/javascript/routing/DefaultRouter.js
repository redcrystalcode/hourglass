import BaseRouter from 'routing/BaseRouter';

const DefaultRouter = BaseRouter.extend({
    defaultRoute: 'terminal',

    routes: {
        '*default': 'default'
    },

    default() {
        this.go(this.defaultRoute);
    }
});

export default DefaultRouter;
