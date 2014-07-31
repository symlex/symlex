define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('MainController', ['$scope', function ($scope) {
        $scope.hello = function () {
            alert('This is a test :-)');
        }
    }]);
});
