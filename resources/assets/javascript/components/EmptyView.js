import {ItemView} from 'backbone.marionette';
import template from 'templates/components/empty-view.tpl';

const EmptyView = ItemView.extend({
    template: template,

    className: 'content__empty',

    // Defaults. Pass these in to the constructor of this class to override.
    heading: "There's nothing here!",
    subhead: "Don't worry. As you add new stuff, you'll see it here.",
    icon: "sentiment_dissatisfied",

    templateHelpers() {
        return {
            heading: this.getOption('heading'),
            subhead: this.getOption('subhead'),
            icon: this.getOption('icon'),
        };
    }
});

export default EmptyView;
