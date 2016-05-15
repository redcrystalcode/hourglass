import {Route} from 'backbone-routing';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const BaseRoute = Route.extend({
    initialize(options = {}) {
        this.options = options;
        this.container = options.container;
    }
});

export default BaseRoute;
