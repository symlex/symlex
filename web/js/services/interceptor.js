define(['services/module', 'services/alert'], function (services) {
    'use strict';

    services.factory('Interceptor', ['$q', '$location', 'Alert', function ($q, $location, Alert) {
        return {
            'responseError': function (response) {

                if (response.data.error) {
                    Alert.error(response.data.error);

                    if(console && console.log && response.data.trace) {
                        console.log('Exception in ' + response.data.file + ' on line ' + response.data.line);
                    }
                } else if (response.data.info) {
                    Alert.info(response.data.info);
                } else if (response.data.warning) {
                    Alert.warning(response.data.warning);
                } else if (response.data.message) {
                    Alert.error(response.data.message);
                } else {
                    var code = '000';

                    if(response && response.status) {
                        code = response.status;
                    }

                    Alert.error('An error has occured, please try again later. Code: ' + code);
                }

                if (response.status == 401) {
                    $location.path('/auth/login');
                }

                return $q.reject(response);
            }
        }
    }])
});
