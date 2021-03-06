import $ from 'jquery';
import _ from 'lodash';
import Cookies from 'js-cookie';
import {sprintf} from 'sprintf-js';
import Radio from 'backbone.radio';

class Api {
    constructor() {
        this.setApiBase();
    }

    setApiBase() {
        let protocol = 'https';
        let domain = this.getDomain();
        this.base = `${protocol}://${domain}/api/`;
    }

    getDomain() {
        let host = document.location.hostname;
        if (host === 'localhost') {
            return 'localhost:' + document.location.port;
        }
        return host;
    }

    url(endpoint, params = null) {
        if (!_.isArray(params)) {
            params = [params];
        }

        let url = params ? sprintf(endpoint, ...params) : endpoint;

        // Remove leading slash from the URL
        if (url.charAt(0) === '/') {
            url = url.substr(1);
        }

        return this.base + url;
    }

    get(endpoint, params = null, data = null) {
        return this.call('GET', this.url(endpoint, params), data);
    }

    post(endpoint, params = null, data = null) {
        return this.call('POST', this.url(endpoint, params), data);
    }

    put(endpoint, params = null, data = null) {
        return this.call('PUT', this.url(endpoint, params), data);
    }

    patch(endpoint, params = null, data = null) {
        return this.call('PATCH', this.url(endpoint, params), data);
    }

    delete(endpoint, params = null, data = null) {
        return this.call('DELETE', this.url(endpoint, params), data);
    }

    call(method, url, data = null, returnXhr = false) {
        let headers = {
            'Accept': 'application/json',
            'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN'),
        };
        let xhr = $.ajax(url, {
            method,
            data,
            headers,
            type: 'json'
        });

        if (returnXhr === true) {
            return xhr;
        }

        return new Promise((resolve, reject) => {
            xhr.done((response) => {
                resolve(response);
            }).fail((response) => {
                reject(response.responseJSON);
            });
        });
    }

}

export default new Api();
