'use strict';

require.config({
    paths: {
        jquery: '../bower_components/jquery/dist/jquery',
        bootstrap: '../bower_components/bootstrap/dist/js/bootstrap',
        angular: '../bower_components/angular/angular',
        angularRoute: '../bower_components/angular-route/angular-route',
        angularResource: '../bower_components/angular-resource/angular-resource',
        angularInfiniteScroll: '../bower_components/angular-infinite-scroll/src/infinite-scroll',
        angularBootstrapTpl: '../bower_components/angular-bootstrap/ui-bootstrap-tpls',
        angularMocks: '../bower_components/angular-mocks/angular-mocks',
        angularLoadingBar: '../bower_components/angular-loading-bar/src/loading-bar',
        text: '../bower_components/text/text'
    },
    shim: {
        'angular' : {'exports' : 'angular'},
        'jquery': {'exports': 'jQuery'},
        'bootstrap': ['jquery'],
        'angularRoute': ['angular'],
        'angularResource': ['angular'],
        'angularInfiniteScroll': ['angular'],
        'angularBootstrapTpl': ['angular'],
        'angularLoadingBar': ['angular'],
        'angularMocks': {
            deps:['angular'],
            'exports':'angular.mock'
        }
    },
    priority: [
        'angular'
    ]
});

require([
    'jquery',
    'angular',
    'app',
    'routing'
], function ($, ng, app) {
    ng.element(document).ready(function () {
        ng.bootstrap(document, ['app']);
    });
});