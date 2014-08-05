define(['directives/module'], function (directives) {
    'use strict';

    directives.directive('ngConfirmClick', [function () {
        return {
            restrict: 'A',
            replace: false,
            link: function($scope, $element, $attr) {
                var msg = $attr.ngConfirmClick || "Are you sure?";
                var clickAction = $attr.confirmedClickAction;
                $element.bind('click', function (event) {
                    if (window.confirm(msg)) {
                        $scope.$eval(clickAction);
                    }
                });
            }
        }
    }]);
});