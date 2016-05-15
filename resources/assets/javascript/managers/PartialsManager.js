import Handlebars from 'hbsfy/runtime';
import loading from 'templates/components/loading-view.tpl';

class PartialsManager {
    register() {
        const partials = {
            loading
        };

        for (var partial of Object.keys(partials)) {
            Handlebars.registerPartial(partial, partials[partial]);
        }
    }
}

export default new PartialsManager();
