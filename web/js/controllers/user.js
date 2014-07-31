define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('UserController', ['$scope', 'Alert', '$modalInstance', 'user', function ($scope, Alert, $modalInstance, user) {
        $scope.user = user;

        $scope.update = function () {
            this.user.$update(function () {
                Alert.success('User successfully updated');
            });
            $modalInstance.close();
        }

        $scope.create = function () {
            this.user.$save(function () {
                Alert.success('User successfully created');
            });
            $modalInstance.close(this.user);
        }

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        }
    }]);
});
