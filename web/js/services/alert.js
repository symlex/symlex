define(['services/module', 'services/eventhub'], function (services) {
    'use strict';

    services.factory('Alert', ['EventHub', function (EventHub) {
        return {
            info: function (message) {
                EventHub.publish('alert.info', message);
            },

            warning: function (message) {
                EventHub.publish('alert.warning', message);
            },

            error: function (message) {
                EventHub.publish('alert.error', message);
            },

            success: function (message) {
                EventHub.publish('alert.success', message);
            }
        }
    }]);

});
