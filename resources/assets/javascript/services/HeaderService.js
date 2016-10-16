import Service from "backbone.service";
import {Collection} from "backbone";
import View from "views/HeaderView";

const HeaderService = Service.extend({
    setup(options = {}) {
        this.container = options.container;
        this.user = options.user;
    },

    start() {
        this.collection = new Collection();
        this.view = new View({collection: this.collection, user: this.user});
        this.container.show(this.view);
    },

    requests: {
        add: 'add',
        remove: 'remove',
        activate: 'activate'
    },
    add(model) {
        this.collection.add(model);
    },
    remove(model) {
        model = this.collection.findWhere(model);
        this.collection.remove(model);
    },
    activate(path) {
        let dotPosition = path.indexOf('.');
        let sub = false;
        if (dotPosition > 0) {
            sub = path.substring(dotPosition + 1);
            path = path.substring(0, dotPosition);
        }
        this.collection.invoke('set', 'active', false);
        let model = this.collection.findWhere({path});
        if (model) {
            model.set('active', true);
            model.set('subpath', sub);
        }
    }
});

export default new HeaderService();
