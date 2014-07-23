define(
    ['jquery', 'can', 'model/session'],
    function ($, can, session) {

        var LoginController = can.Control.extend({
        });

        return new LoginController('#login');
    });