import {CompositeView} from 'backbone.marionette';
import template from 'templates/sidebar.tpl';

const OnTheClockSidebarView = CompositeView.extend({
    template,
    className: 'sidebar'
});

export default OnTheClockSidebarView;
