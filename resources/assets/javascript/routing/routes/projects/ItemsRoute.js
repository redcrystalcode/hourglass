import BaseRoute from 'routing/routes/BaseRoute';
// import ProjectModel from 'models/ProjectModel';
import ProjectLayoutView from 'views/projects/detail/ProjectLayoutView';

/**
 * @docs https://github.com/thejameskyle/backbone-routing
 */
const ItemsRoute = BaseRoute.extend({
    fetch() {
        this.model = new ProjectModel({
            id: this.options.projectId
        });
        return this.model.fetch();
    },
    render() {
        this.container.show(new ProjectLayoutView({
            model: this.model,
        }));
    }
});

export default ItemsRoute;
