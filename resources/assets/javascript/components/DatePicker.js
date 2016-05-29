import Marionette from "backbone.marionette";
import $ from 'jquery';
import Pikaday from 'pikaday';

const DatePicker = Marionette.Object.extend({
    initialize(options) {
        this.options = options;
        this.options.field = $(options.field);
        this.picker = new Pikaday({
            field: this.options.field[0],
            format: this.options.format || 'ddd, MMM D, Y',
            i18n: {
                previousMonth: 'Previous Month',
                nextMonth: 'Next Month',
                months: [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ],
                weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                weekdaysShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S']
            },
            onSelect: this.onSelect.bind(this)
        });
    },
    onSelect(value) {
        if (this.options.field.hasClass('mdl-textfield__input')) {
            this.options.field.parent()[0].MaterialTextfield.checkDirty();
        }
        this.trigger('select', value);
    }
});

export default DatePicker;
