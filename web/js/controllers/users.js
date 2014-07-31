define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('UsersController', ['$scope', '$modal', 'Api', function ($scope, $modal, api) {
        var userResource = api.getUserResource();

        $scope.users = userResource.query();

        $scope.remove = function (index) {
            $scope.users[index].$remove();
            $scope.users.splice(index, 1);
        }

        $scope.edit = function (user) {
            $modal.open({
                templateUrl: '/partials/dialog/user/edit.html',
                controller: 'UserController',
                resolve: {
                    user: function () {
                        return user;
                    }
                }
            });
        }

        $scope.create = function () {
            var modalInstance = $modal.open({
                templateUrl: '/partials/dialog/user/create.html',
                controller: 'UserController',
                resolve: {
                    user: function () {
                        return new userResource;
                    }
                }
            });

            modalInstance.result.then(function (newUser) {
                $scope.users.push(newUser);
            });
        }
    }]);
});
