import {Application} from 'backbone.marionette';
import Radio from 'backbone.radio';
import _ from 'lodash';
import $ from 'jquery';
import nprogress from 'nprogress';

nprogress.configure({
    showSpinner: false
});

export default Application.extend({
    initialize() {
        this.$body = $(document.body);
        this.routerChannel = Radio.channel('router');
        this.listenTo(this.routerChannel, {
            'before:enter': this.onBeforeEnterRoute,
            'route': this.onRoute,
            'enter': this.onEnterRoute,
            'error': this.onErrorRoute
        });
    },
    onBeforeEnterRoute() {
        if (window.Bugsnag !== undefined) {
            window.Bugsnag.refresh();
        }
        console.log('onBeforeEnterRoute');
        this.transitioning = true;
        // Don't show for synchronous route changes
        _.defer(() => {
            if (this.transitioning) {
                nprogress.start();
            }
        });
    },

    onEnterRoute() {
        console.log('onEnterRoute');
        this.transitioning = false;
        this.$body.scrollTop(0);
        nprogress.done();
    },

    onRoute() {
        console.log('onRoute');
    },

    onErrorRoute() {
        console.log('onErrorRoute');
        this.transitioning = false;
        nprogress.done(true);
    }
});
