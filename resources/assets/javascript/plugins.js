import Backbone from 'backbone';
import $ from 'jquery';
import _ from 'lodash';
import Marionette from 'backbone.marionette';
import PartialsManager from 'managers/PartialsManager';
import Handlebars from 'hbsfy/runtime';
import api from 'core/Api';
import 'bootstrap';
import 'backbone.syphon';
import 'backbone-query-parameters';
import 'babel-polyfill';
import 'form-serializer';
import 'date-util';
Backbone.$ = $;

// Register partials.
PartialsManager.register();

// start the marionette inspector
if (window.__agent) {
    window.__agent.start(Backbone, Marionette);
}

// Allow returning functions and JSONable objects in template helpers.
Marionette.View.prototype.mixinTemplateHelpers = function(target) {
    target = target || {};
    var templateHelpers = this.getOption('templateHelpers');
    templateHelpers = Marionette._getValue(templateHelpers, this);

    _.each(templateHelpers, function(helper, index) {
        helper = Marionette._getValue(helper, this);

        if (helper && _.isFunction(helper.toJSON)) {
            helper = helper.toJSON();
        }

        templateHelpers[index] = helper;
    });

    return _.extend(target, templateHelpers);
};

// Proxy Backbone.ajax to our API class.
Backbone.ajax = function(params) {
    return new Promise((resolve, reject) => {
        var data = _.isString(params.data) ? JSON.parse(params.data) : params.data;
        api.call(params.type, api.url(params.url, {}), data)
            .then((response) => {
                if (params.success) {
                    params.success.call(this, response);
                }
                resolve();
            })
            .catch((response) => {
                if (params.error) {
                    params.error.call(this, response);
                }
                reject(response);
            });
    });
};

Handlebars.registerHelper('compare', function(lvalue, operator, rvalue, options) {
    var operators;
    var result;

    if (arguments.length < 3) {
        throw new Error("Handlerbars Helper 'compare' needs 2 parameters");
    }

    if (options === undefined) {
        options = rvalue;
        rvalue = operator;
        operator = "===";
    }

    operators = {
        '==': function(l, r) {
            // eslint-disable-next-line
            return l == r;
        },
        '===': function(l, r) {
            return l === r;
        },
        '!=': function(l, r) {
            return l !== r;
        },
        '!==': function(l, r) {
            return l !== r;
        },
        '<': function(l, r) {
            return l < r;
        },
        '>': function(l, r) {
            return l > r;
        },
        '<=': function(l, r) {
            return l <= r;
        },
        '>=': function(l, r) {
            return l >= r;
        },
        'typeof': function(l, r) {
            return typeof l === r;
        }
    };

    if (!operators[operator]) {
        throw new Error("Handlerbars Helper 'compare' doesn't know the operator " + operator);
    }

    result = operators[operator](lvalue, rvalue);

    if (result) {
        return options.fn(this);
    }
    return options.inverse(this);
});

Handlebars.registerHelper('pluralize', function(number, single, plural) {
    if (number === 1) {
        return single;
    }
    return plural;
});
