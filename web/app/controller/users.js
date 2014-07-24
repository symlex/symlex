define(
    ['jquery', 'can', 'model/user'],
    function ($, can, user) {

        var controller = can.Control.extend({
            init: function (el, options) {
                user.findAll({}, function(users) {
                    controller.users = users;
                    el.html(new can.view('/app/views/users.ejs', { users: users }));
                });
            }
        });

        return controller;
    });