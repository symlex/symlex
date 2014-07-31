define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('UserController', ['$scope', 'Api', '$modalInstance', 'user', function ($scope, api, $modalInstance, user) {
        $scope.user = user;

        $scope.update = function () {
            this.user.$update();
            $modalInstance.close();
        }

        $scope.create = function () {
            this.user.$save();
            $modalInstance.close(this.user);
        }

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        }
    }]);
});
