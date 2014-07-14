require(
    ['jquery', 'can'],
    function ($, can) {

        var LoginController = can.Control.extend({
            'submit': function (el, ev) {
                ev.preventDefault();
                alert('Login :-)');
            }
        });

        new LoginController($("#login"));
    });