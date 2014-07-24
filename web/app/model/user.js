define(
    ['jquery', 'can'],
    function ($, can) {

        var model = can.Model.extend({
            findAll: 'GET /api/user',
            findOne: 'GET /api/user/{id}',
            create:  'POST /api/user',
            update:  'PUT /api/user/{id}',
            destroy: 'DELETE /api/user/{id}'
        }, {});

        return model;
    });