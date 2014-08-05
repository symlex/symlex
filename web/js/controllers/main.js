define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('MainController', ['$scope', function ($scope) {
        $scope.config = window.appConfig;
    }]);
});
