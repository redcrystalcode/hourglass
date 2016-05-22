import $ from 'jquery';
import _ from 'lodash';
import {ItemView} from 'backbone.marionette';
import {Collection} from 'backbone';
import ApplicationService from 'services/ApplicationService';
import template from 'templates/header.tpl';

const HeaderView = ItemView.extend({
    template,
    tagName: 'header',
    className: 'navbar',

    collectionEvents: {
        all: 'render'
    },

    ui: {
        selector: '.navbar__selector'
    },

    events: {
        'click .selector__back': 'goBack',
        'click @ui.selector': 'openSelector'
    },

    initialize(options) {
        this.user = options.user;
        this.listenTo(this.user, 'change', this.render);
    },

    templateHelpers() {
        var self = this;

        return {
            user: self.user,
            logged_in() {
                return Boolean(self.user.id);
            },
            unauthenticated_links() {
                return new Collection(self.collection.where({type: 'unauthenticated', active: false}));
            },
            selected() {
                return self.getSelected();
            },
            primary_links() {
                return new Collection(self.collection.where({
                    type: 'primary'
                }));
            }
        };
    },

    goBack(e) {
        e.stopPropagation();
        e.preventDefault();

        ApplicationService.request('route', this.getSelected().get('path'));
    },

    openSelector(e) {
        if ($(e.target).is('.selector__option a')) {
            return;
        }
        e.stopPropagation();

        // Check if other navbar__selector is open.
        var others = $('.navbar__selector--open');
        _.each(others, (selector) => {
            this.closeSelector.call(selector);
        });

        var selector = e.currentTarget;
        $(selector).addClass('navbar__selector--open');
        $('body').one('click', this.closeSelector.bind(selector));
    },

    closeSelector() {
        $(this).addClass('navbar__selector--closing').one('animationend', () => {
            $(this).removeClass('navbar__selector--closing')
                .removeClass('navbar__selector--open');
        });
    },

    getSelected() {
        return this.collection.findWhere({
            type: 'primary',
            active: true,
        });
    }
});

export default HeaderView;
