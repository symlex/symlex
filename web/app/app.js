require.config({
    paths: {
        jquery: 'lib/jquery',
        can: 'lib/can'
    }
});

require(['jquery', 'can', 'controller/navigation'],
    function ($, can) {
        var hashchangeCallback = function() {
            var page = location.hash.substr(1);

            if(!page.length) {
                page = 'index';
            }

            $('#main').html(new can.view('/app/views/' + page + '.ejs', {}));
        }

        $(window).bind('hashchange', hashchangeCallback);

        hashchangeCallback();
    }
);
