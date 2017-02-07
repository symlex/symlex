'use strict';

define([
    'angular',
    'angularRoute',
    'angularResource',
    'angularInfiniteScroll',
    'angularBootstrapTpl',
    'angularLoadingBar',
    'bootstrap',
    'services',
    'directives',
    'controllers'
], function (ng) {
    return ng.module('app', [
        'ngRoute',
        'ngResource',
        'app.directives',
        'app.services',
        'app.controllers',
        'ui.InfiniteScroll',
        'angular-loading-bar',
        'ui.bootstrap',
        'ui.bootstrap.tpls'
    ], ['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.common["X-CSRF-Token"] = appConfig.csrf_token;
        $httpProvider.interceptors.push('Interceptor');
    }]);
});