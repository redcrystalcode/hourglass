import Service from 'backbone.service';

const ApplicationService = Service.extend({
    setup(options = {}) {
        this.app = options.app;
    },

    requests: {
        'route': 'route',
        'navigate': 'navigate',
        'user': 'user',
        'sidebar:hide': 'hideSidebar',
        'sidebar:show': 'showSidebar'
    },

    route(route) {
        return this.app.router.go(route);
    },

    navigate(route) {
        return this.app.router.navigate(route);
    },

    user() {
        return this.app.user;
    },

    showSidebar() {
        this.app.layout.$el.addClass('app--with-sidebar');
    },

    hideSidebar() {
        this.app.layout.$el.removeClass('app--with-sidebar');
    }
});

export default new ApplicationService();
