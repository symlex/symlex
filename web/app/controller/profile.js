define(
    ['jquery', 'can', 'model/user'],
    function ($, can, user) {

        var controller = can.Control.extend({
            init: function (el, options) {
                user.findOne({id: appConfig.user_id }, function(user) {
                    controller.user = user;
                    el.html(new can.view('/app/views/profile.ejs', { user: user }));
                });
            }
        });

        return controller;
    });