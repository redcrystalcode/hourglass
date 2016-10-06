import BaseCollection from 'collections/BaseCollection';
import RoundingRuleModel from 'models/RoundingRuleModel';

const RoundingRulesCollection = BaseCollection.extend({
    url: '/rounding-rules',
    model: RoundingRuleModel,
    comparator(model) {
        return model.get('start');
    }
});

export default RoundingRulesCollection;
