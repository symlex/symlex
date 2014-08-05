define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('NavigationController', ['$scope', '$location', function ($scope, $location) {
        $scope.login = {
            email: '',
            password: ''
        };

        $scope.isActive = function (viewLocation) {
            var path = $location.path();
            return path.indexOf(viewLocation) === 0;
        };
    }]);
});
