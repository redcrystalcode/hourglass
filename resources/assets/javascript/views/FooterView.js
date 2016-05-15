import {ItemView} from 'backbone.marionette';
import template from 'templates/footer.tpl';

const FooterView = ItemView.extend({
    template,
    tagName: 'footer',
    className: 'footer',
});

export default FooterView;
