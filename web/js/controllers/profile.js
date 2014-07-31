define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('ProfileController', ['$scope', '$routeParams', 'Api', 'Alert', function ($scope, $routeParams, Api, Alert) {
        var userResource = Api.getUserResource();

        $scope.user = userResource.get({user_id: $routeParams.userId});

        $scope.update = function () {
            this.user.$update(function () {
                Alert.success('Profile successfully saved');
            });
        }
    }]);
});
