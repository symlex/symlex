define(['services/module'], function (services) {
    'use strict';
    services.service('Api', ['$resource', function ($resource) {
        function userFactory () {
            return $resource(
                "/api/users/:user_id",
                {
                    user_id: "@user_id"
                },
                {
                    update: { method: 'PUT' }
                }
            );
        }

        return {
            getUserResource : userFactory
        }
    }]);
});
