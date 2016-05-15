import Backbone from 'backbone';
import $ from 'jquery';
import _ from 'lodash';
Backbone.$ = $;
import Marionette from 'backbone.marionette';
import PartialsManager from 'managers/PartialsManager';
import api from 'core/Api';
import 'bootstrap';
import 'backbone.syphon';
import 'backbone-query-parameters';
import 'babel-polyfill';
import 'form-serializer';
import 'date-util';

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
