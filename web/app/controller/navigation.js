require(
    ['jquery', 'can'],
    function ($, can) {

    var NavigationController = can.Control.extend({
        '#login submit': function (el, ev) {
            ev.preventDefault();
            alert('Login :-)');
        },

        'ul a click': function (el, ev) {
            el.parent().addClass('active').siblings().removeClass('active');
        },

        'div.navbar-header a.navbar-brand click': function (el, ev) {
            this.element.find('ul li').removeClass('active');
        }
    });

    var navigation = new NavigationController($("#navigation"));
});