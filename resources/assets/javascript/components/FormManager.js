import Marionette from 'backbone.marionette';
import FormValidator from 'components/FormValidator';
import {getFormData} from 'helpers';

const FormManager = Marionette.Object.extend({
    initialize(options) {
        this.form = options.form;
        this.model = options.model;

        this.validator = new FormValidator(options);

        this.form.on('submit', (e) => {
            this.submit(e);
        });
        this.form.find('input').first().focus();
    },

    /**
     * Submit the form
     * @param {jQuery.Event} event (optional) - used for jQuery event binding
     * @return {Promise}
     */
    submit(event = null) {
        if (event) {
            event.preventDefault();
        }
        return this._save();
    },

    /**
     * Get data from the form.
     * @return {object}
     */
    getData() {
        return getFormData(this.form);
    },

    /**
     * Save the model with the updated data from the form.
     * @return {Promise}
     * @private
     */
    _save() {
        this.model.set(this.getData());
        return new Promise((resolve) => {
            this.model.save()
                .then(() => {
                    this.trigger('save:success');
                    resolve();
                })
                .catch((errors) => {
                    this.model.reset();
                    this._showErrors(errors);
                });
        });
    },

    /**
     * @param {object} errors - xhr errors
     * @private
     */
    _showErrors(errors) {
        this.validator.showServerErrors(errors);
    }
});

export default FormManager;
