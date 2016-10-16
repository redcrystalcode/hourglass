import Service from 'backbone.service';
import LoadingView from 'components/LoadingView';

const LoadingService = Service.extend({
    setup(options = {}) {
        this.container = options.container;
    },

    requests: {
        start: 'startLoader',
        stop: 'stopLoader',
    },

    startLoader(container = null) {
        let target = container || this.container;
        target.show(new LoadingView());
    },

    stopLoader(container = null) {
        let target = container || this.container;
        target.empty();
    }
});

export default new LoadingService();
