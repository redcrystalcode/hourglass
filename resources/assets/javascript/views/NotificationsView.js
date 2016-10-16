import {Model, Collection} from 'backbone';
import _ from 'lodash';
import moment from 'moment';
import Radio from 'backbone.radio';
import {ItemView, CollectionView} from 'backbone.marionette';
import template from 'templates/notification.tpl';

const NotificationItemView = ItemView.extend({
    template,
    className: 'notification',
    modelEvents: {
        dismiss: 'dismiss'
    },
    templateHelpers() {
        let timestamp = this.model.get('timestamp');
        return {
            timestamp: moment(timestamp).format('h:mm a')
        };
    },
    dismiss() {
        this.$el.addClass('animate-out').on('animationend', () => {
            this.model.collection.remove(this.model);
        });
    }
});
const NotificationsView = CollectionView.extend({
    className: 'notification-container',
    childView: NotificationItemView,
    channel: Radio.channel('notifications'),
    initialize() {
        this.collection = new Collection();
        this.collection.comparator = function(model) {
            console.log(model.get('timestamp'));
            console.log(moment(model.get('timestamp')).unix());
            return -1 * moment(model.get('timestamp')).unix();
        };
        this.listenTo(this.channel, {
            show: this.showNotification
        });
    },
    showNotification(notification) {
        let model = new Model(notification);
        if (!model.get('timestamp')) {
            model.set('timestamp', moment().unix());
        }
        this.collection.add(model);
        _.delay(() => {
            model.trigger('dismiss');
        }, 3500);
    }
});

export default NotificationsView;
