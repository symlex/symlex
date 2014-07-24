require.config({
    paths: {
        jquery: 'lib/jquery',
        can: 'lib/can',
        bootstrap: 'lib/bootstrap'
    }
});

require(['jquery', 'can', 'controller/navigation', 'controller/index', 'controller/profile', 'controller/users', 'can/view/ejs', 'bootstrap'],
    function ($, can, navigation, index, profile, users) {
        var hashchangeCallback = function() {
            var page = location.hash.substr(1);
            var el = $('#main');

            if(!page.length) {
                page = 'index';
            }

            if(el.length) {
                switch (page) {
                    case 'index':
                        new index (el);
                        break;
                    case 'profile':
                        new profile (el);
                        break;
                    case 'users':
                        new users (el);
                        break;
                }
            }
        }

        $(window).bind('hashchange', hashchangeCallback);

        new navigation('#navigation');

        hashchangeCallback();
    }
);
