define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('PasswordController', ['$scope', '$http', 'Alert', '$modalInstance', 'user', function ($scope, $http, Alert, $modalInstance, user) {
        $scope.form = {
            password: '',
            new_password: '',
            new_password_confirm: ''
        };

        $scope.user = user;

        $scope.submit = function () {
            $http.put('/api/user/' + user.user_id + '/password', $scope.form).success(function () {
                    Alert.success('Password successfully updated');
                    $modalInstance.close();
                }
            );

        }

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        }
    }]);
});
