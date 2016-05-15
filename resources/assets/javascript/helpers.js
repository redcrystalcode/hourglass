import _ from 'lodash';
import Cocktail from 'backbone.cocktail';

/**
 * Get serialized data from a <form> element.
 * @param {jQuery} $form
 * @return {object}
 */
export function getFormData($form) {
    return JSON.parse($form.serializeJSON());
}

/**
 * Set up default sort for a Backbone collection.
 * @param {Backbone.Collection} Collection
 */
export function setUpDefaultSort(Collection) {
    let proto = Collection.prototype;
    let rule = proto.sortRules[proto.defaultSort];

    _.extend(proto.state, {
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
