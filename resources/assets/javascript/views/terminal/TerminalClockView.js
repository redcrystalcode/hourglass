import {Model} from 'backbone';
import {ItemView} from 'backbone.marionette';
import template from 'templates/terminal/clock.tpl';

const TerminalClockView = ItemView.extend({
    template,

    initialize() {
        this.model = new Model();
        this.interval = setInterval(this.updateClock.bind(this), 1000);
        this.updateClock();
        this.listenTo(this.model, 'change', this.render);
    },

    updateClock() {
        let now = new Date();
        this.model.set({
            hours: now.format('h'),
            minutes: now.format('MM'),
            am_pm: now.format('TT'),
        });
    },

    onBeforeDestroy() {
        clearInterval(this.interval);
    }
});

export default TerminalClockView;
