import $ from 'jquery';
import {ItemView} from 'backbone.marionette';

const Overlay = ItemView.extend({
    template: false,
    className: 'overlay',
    triggers: {
        click: 'close',
    },
    events: {
        close: 'close',
    },
    open() {
        this.container = $('.app__overlay-container');
        this.render();
        this.container.append(this.$el);
        this.$el.addClass('overlay--visible');
        $(document.body).addClass('overlay-opened');
    },
    close() {
        this.$el.removeClass('overlay--visible').on('transitionend', () => {
            this.$el.remove();
            this.cleanupBodyClass();
            this.destroy();
        });
    },
    cleanupBodyClass() {
        if (this.container.find('.overlay').length === 0) {
            $(document.body).removeClass('overlay-opened');
        }
    }
});

export default Overlay;
