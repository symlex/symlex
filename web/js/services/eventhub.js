define(['services/module'], function (services) {
    'use strict';

    services.factory('EventHub', function () {
        var channels = {};

        return {
            publish: function (topic) {
                var args = Array.prototype.slice.call(arguments, 1);
                channels[topic] && channels[topic].forEach(function (callback) {
                    callback.apply(null, args);
                });
            },

            subscribe: function (topic, callback) {
                if (!(callback instanceof Function)) {
                    throw new Error('callback must be a function');
                }

                if (!channels[topic]) {
                    channels[topic] = [];
                }

                channels[topic].push(callback);
            },

            unsubscribe: function (topic, callback) {
                channels[topic] && channels[topic].forEach(function (value, index) {
                    if (value === callback) {
                        channels[topic].splice(index, 1);
                    }
                });
            }
        }
    });

});
