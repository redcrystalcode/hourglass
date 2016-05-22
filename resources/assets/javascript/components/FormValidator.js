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
        this.form.find('[data-validation-error-for]').empty();
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
        var input = this.form.find('[name="' + name + '"]');
        var errorTextEl;

        if (input.length) {
            var textfield = input.parent();
            textfield.addClass(this.errorClass)
                .find('.' + this.errorTextClass);
            errorTextEl = textfield.find('.' + this.errorTextClass);
            if (errorTextEl.length === 0) {
                errorTextEl = $('<div/>', {class: this.errorTextClass});
                textfield.append(errorTextEl);
            }
        } else {
            errorTextEl = this.form.find('[data-validation-error-for="' + name + '"]');
        }

        errorTextEl.text(errorText);
    },
});

export default FormValidator;
