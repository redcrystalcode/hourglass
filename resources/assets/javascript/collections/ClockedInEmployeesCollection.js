import {Collection} from 'backbone';
import moment from 'moment';

export default Collection.extend({
    comparator(model) {
        return -1 * moment(model.get('time_in')).unix();
    }
});
