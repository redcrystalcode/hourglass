import BaseModel from 'models/BaseModel';
import moment from 'moment';

const RoundingRuleModel = BaseModel.extend({
    urlRoot: '/rounding-rules',

    formatTime(property) {
        let value = this.get(property);
        if (!value) {
            return null;
        }
        return moment(value, 'HH:mm').format('h:mm A');
    },
});

export default RoundingRuleModel;
