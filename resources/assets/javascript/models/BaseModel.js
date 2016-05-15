import {Model} from 'backbone';

/**
 * This is the "abstract" base model for all
 * Hourglass models. Do not use this directly.
 */
const BaseModel = Model.extend({
    parse(response) {
        // When fetched independently, the model is
        // wrapped in a `data` attribute
        if (response.data && !response.id) {
            return response.data;
        }

        // When fetched within a collection,
        // the model is served plainly.
        return response;
    },

    /**
     * Reset the model to the previously valid state.
     */
    reset() {
        this.set(this.previousAttributes());
    }
});

export default BaseModel;
