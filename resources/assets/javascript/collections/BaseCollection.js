import {Collection} from 'backbone';

/**
 * This is the "abstract" base collection for all
 * Hourglass collections. Do not use this directly.
 */
const BaseCollection = Collection.extend({
    parse(response) {
        return response.data || response;
    }
});

export default BaseCollection;
