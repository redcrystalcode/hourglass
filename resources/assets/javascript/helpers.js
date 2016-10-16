import _ from 'lodash';
import $ from 'jquery';
import moment from 'moment';
import Cocktail from 'backbone.cocktail';

/**
 * Get serialized data from a <form> element.
 * @param {jQuery} $form
 * @return {object}
 */
export function getFormData($form) {
    let data = JSON.parse($form.serializeJSON());

    // Support nested properties using dot notation.
    $form.find('[name]').each(function() {
        // Exclude checkboxes, which are handled properly above.
        let $el = $(this);
        if ($el.attr('type') === 'checkbox') {
            return;
        }

        let name = $el.attr('name');
        if (!_.get(data, name)) {
            _.set(data, name, $el.val());
        }
    });

    return data;
}

/**
 * Set up default sort for a Backbone collection.
 * @param {Backbone.Collection} Collection
 */
export function setUpDefaultSort(Collection) {
    let proto = Collection.prototype;
    let rule = proto.sortRules[proto.defaultSort];

    Collection.prototype.state = _.extend({}, proto.state, {
        sortKey: rule.attr,
        order: rule.dir,
    });
}

/**
 * Mixin using Cocktail.
 * @param {object} target
 * @param {...object} mixins
 */
export function mixin(target, ...mixins) {
    Cocktail.mixin(target, ...mixins);
}

/**
 * Mixin soft deletes functionality.
 * @param {object} target
 */
export function softDeletes(target) {
    /**
     * Add soft-delete functionality
     * @param {object} options
     * @returns {boolean|jQuery.xhr}
     */
    target.prototype.archive = function(options) {
        options = _.extend({validate: true, parse: true}, options);

        // After a successful server-side save, the client is (optionally)
        // updated with the server-side state.
        var model = this;
        var success = options.success;
        var attributes = this.attributes;
        options.success = function(resp) {
            // Ensure attributes are restored during synchronous saves.
            model.attributes = attributes;
            var serverAttrs = options.parse ? model.parse(resp, options) : resp;
            if (serverAttrs && !model.set(serverAttrs, options)) {
                return false;
            }
            if (success) {
                success.call(options.context, model, resp, options);
            }
            model.trigger('sync', model, resp, options);
        };

        var wrapError = function(model, options) {
            var error = options.error;
            options.error = function(resp) {
                if (error) {
                    error.call(options.context, model, resp, options);
                }
                model.trigger('error', model, resp, options);
            };
        };

        var xhr = false;
        if (this.isNew()) {
            _.defer(options.success);
        } else {
            wrapError(this, options);
            xhr = this.sync('delete', this, options);
        }

        return xhr;
    };
}

export function time(val) {
    if (!val) {
        return null;
    }
    return moment.utc(val).local().format('hh:mm A');
}
