define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('ProfileController', ['$scope', '$routeParams', 'Api', function ($scope, $routeParams, api) {
        var userResource = api.getUserResource();

        $scope.user = userResource.get({user_id: $routeParams.userId});
    }]);
});
