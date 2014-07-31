({
    baseUrl: './',
    paths: {
        jquery: 'lib/jquery',
        bootstrap: 'lib/bootstrap',
        angular: 'lib/angular',
        angularRoute: 'lib/angular-route',
        angularResource: 'lib/angular-resource',
        angularInfiniteScroll: 'lib/angular-infinite-scroll',
        angularBootstrapTpl: 'lib/ui-bootstrap-tpls',
        angularMocks: 'lib/angular-mocks',
        angularLoadingBar: 'lib/angular-loading-bar',
        text: 'lib/requirejs-text'
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
    name: "main",
    out: "main-built.js"
})