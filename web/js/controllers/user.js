define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('UserController', ['$scope', 'Alert', '$uibModalInstance', 'user', function ($scope, Alert, $modalInstance, user) {
        $scope.user = user;

        $scope.update = function () {
            $scope.user.$update(function (user) {
                Alert.success('User successfully updated');
                $modalInstance.close(user);
            });
        }

        $scope.create = function () {
            $scope.user.$save(function (user) {
                Alert.success('User successfully created');
                $modalInstance.close(user);
            });
        }

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        }
    }]);
});
