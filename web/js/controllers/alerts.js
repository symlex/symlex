define(['controllers/module', 'services/alert'], function (controllers) {
    'use strict';

    return controllers.controller('AlertsController', ['$scope', '$timeout', 'EventHub', function ($scope, $timeout, EventHub) {
        var lastMessageId = 0;
        var lastMessage = '';

        $scope.alerts = [];

        var addWarningMessage = function (message) {
            addMessage('warning', message, 2500);
        };

        var addErrorMessage = function (message) {
            addMessage('error', message, 4000);
        };

        var addSuccessMessage = function (message) {
            addMessage('success', message, 3000);
        };

        var addInfoMessage = function (message) {
            addMessage('info', message, 2000);
        };

        var addMessage = function (type, message, delay) {
            if(message == lastMessage) return;

            lastMessageId++;
            lastMessage = message;

            var alert = {'id': lastMessageId, 'type': type, 'msg': message};

            $scope.alerts.push(alert);

            $timeout(function () {
                $scope.alerts.shift();
                lastMessage = '';
            }, delay);
        };

        $scope.closeAlert = function (index) {
            $scope.alerts.splice(index, 1);
        };

        EventHub.subscribe('alert.info', addInfoMessage);
        EventHub.subscribe('alert.warning', addWarningMessage);
        EventHub.subscribe('alert.error', addErrorMessage);
        EventHub.subscribe('alert.success', addSuccessMessage);
    }]);
});