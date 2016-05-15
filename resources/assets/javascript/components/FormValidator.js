import Marionette from 'backbone.marionette';
import _ from 'lodash';
import $ from 'jquery';

const FormValidator = Marionette.Object.extend({
    initialize(options) {
        this.form = options.form;
        this.errorClass = options.errorClass || 'mdl-textfield--invalid';
        this.errorTextClass = options.errorTextClass || 'mdl-textfield__error';
        this.form.on('submit', this.clearErrors.bind(this));

        if (!this.form) {
            throw new TypeError('FormValidator must receive a form instance.');
        }
    },

    clearErrors() {
        this.form.find('.' + this.errorClass).removeClass(this.errorClass);
    },

    showServerErrors(errors) {
        _.forOwn(errors, (error, name) => {
            if (_.isArray(error)) {
                error = error[0];
            }
            this.showError(name, error);
        });
    },

    showError(name, errorText) {
        var textfield = this.form
            .find('[name="' + name + '"]')
            .parent();

        textfield.addClass(this.errorClass)
            .find('.' + this.errorTextClass);

        var errorTextEl = textfield.find('.' + this.errorTextClass);
        if (errorTextEl.length === 0) {
            errorTextEl = $('<div/>', {class: this.errorTextClass});
            textfield.append(errorTextEl);
        }
        errorTextEl.text(errorText);
    },
});

export default FormValidator;
