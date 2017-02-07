define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('ProfileController', ['$scope', '$routeParams', 'Api', 'Alert', '$uibModal', function ($scope, $routeParams, Api, Alert, $modal) {
        var userResource = Api.getUserResource();

        $scope.user = userResource.get({user_id: $routeParams.userId});

        $scope.update = function () {
            this.user.$update(function () {
                Alert.success('Profile successfully saved');
            });
        }

        $scope.changePassword = function () {
            $modal.open({
                templateUrl: '/partials/dialog/user/password.html',
                controller: 'PasswordController',
                resolve: {
                    user: function () {
                        return $scope.user;
                    }
                }
            });
        }
    }]);
});
