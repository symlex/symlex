require.config({
    paths: {
        jquery: 'lib/jquery',
        can: 'lib/can'
    }
});

require(['jquery', 'can', 'controller/navigation', 'controller/login'],
    function ($, can) {
        var hashchangeCallback = function() {
            var page = location.hash.substr(1);
            var el = $('#main');

            if(!page.length) {
                page = 'index';
            }

            if(el.length) {
                el.html(new can.view('/app/views/' + page + '.ejs', {}));
            }
        }

        $(window).bind('hashchange', hashchangeCallback);

        hashchangeCallback();
    }
);
