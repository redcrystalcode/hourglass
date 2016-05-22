import {Router} from 'backbone-routing';
import Radio from 'backbone.radio';
import api from 'core/Api';

const BaseRouter = Router.extend({
    initialize(options = {}) {
        this.channel = Radio.channel('router');
        this.on('all', this._onRouterEvent);
        this.container = options.container;
        this.onInitialize();
    },

    _onRouterEvent(name, ...args) {
        this.channel.trigger(name, this, ...args);
    },

    /**
     * @abstract
     */
    onInitialize: function() {},

    go(route) {
        this.navigate(route, {trigger: true});
    },

    /**
     * This internally-called function handles redirects for
     * authentication.
     */
    execute() {
        // Routing using Backbone.History to a subroute of an active route was
        // breaking nprogress and the route listeners. This ensures that ALL
        // navigation is treated the same.
        this._isActive = false;

        Router.prototype.execute.apply(this, arguments);
    }
});

export default BaseRouter;
