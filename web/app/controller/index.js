define(
    ['jquery', 'can'],
    function ($, can) {

        var controller = can.Control.extend({
            init: function (el, options) {
                el.html(new can.view('/app/views/index.ejs', { }));
            }
        });

        return controller;
    });