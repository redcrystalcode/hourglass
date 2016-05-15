import SelectButton from 'components/SelectButton';
import _ from 'lodash';

const SortButton = SelectButton.extend({

    initialize(options) {
        var collection = options.collection;
        var rules = collection.sortRules;
        var items = [];

        this.sortableCollection = collection;

        _.keys(rules).forEach(function(key) {
            items.push({
                key: key,
                label: rules[key].label
            });
        });

        var defaultSelection = _.findIndex(items, function(item) {
            return item.key === collection.defaultSort;
        });

        options = {
            icon: 'sort',
            items: items,
            defaultSelection: defaultSelection
        };

        SelectButton.prototype.initialize.call(this, options);
    },

    onSelected() {
        var rules = this.getSortRules(this.model.toJSON());
        this.updateSort(rules);
    },

    onReset() {
        var rules = this.getSortRules(this.model.toJSON());
        this.updateSort(rules);
    },

    getSortRules(sort) {
        if (!this.sortableCollection.sortRules) {
            throw new Error('No sort rules exist in the collection.');
        }

        return this.sortableCollection.sortRules[sort.key];
    },

    updateSort(rules) {
        this.sortableCollection.setSorting(rules.attr, rules.dir);
        this.sortableCollection.fetch();
    },
});

export default SortButton;
