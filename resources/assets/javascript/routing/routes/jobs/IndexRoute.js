import BaseRoute from 'routing/routes/BaseRoute';
import JobsLayoutView from 'views/jobs/JobsLayoutView';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const IndexRoute = BaseRoute.extend({
    render() {
        this.container.show(new JobsLayoutView());
    }
});

export default IndexRoute;
