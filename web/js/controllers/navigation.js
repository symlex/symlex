define(['controllers/module'], function (controllers) {
    'use strict';
    return controllers.controller('NavigationController', ['$scope', function ($scope) {
        $scope.hello = function () { alert('Hello World!'); }
    }]);
});
