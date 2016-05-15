import Service from 'backbone.service';

const ApplicationService = Service.extend({
    setup(options = {}) {
        this.app = options.app;
    },

    requests: {
        route: 'route',
        user: 'user'
    },

    route(route) {
        return this.app.router.go(route);
    },

    user() {
        return this.app.user;
    }
});

export default new ApplicationService();
