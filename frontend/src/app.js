import Vue from 'vue';
import Router from 'vue-router';
import '../css/app.css';
import App from 'app/main.vue';
import routes from 'app/routes';
import Api from 'common/api';
import VueMaterial from 'vue-material';
import AppComponents from 'component/app-components';
import Alert from 'common/alert';
import Session from 'common/session';
import Event from 'pubsub-js';

const session = new Session(window.localStorage);

Vue.prototype.$event = Event;
Vue.prototype.$alert = Alert;
Vue.prototype.$session = session;
Vue.prototype.$api = Api;
Vue.prototype.$config = window.appConfig;

Vue.use(VueMaterial);
Vue.use(AppComponents);
Vue.use(Router);

Vue.material.registerTheme('default', {
    primary: {
        color: 'cyan',
        hue: 700,
    },
    accent: {
        color: 'cyan',
        hue: 800,
    },
    warn: {
        color: 'deep-orange',
        hue: 700,
    },
});

Vue.material.registerTheme('cards', {
    primary: {
        color: 'grey',
        hue: 300,
    },
    accent: {
        color: 'grey',
        hue: 800,
    },
    warn: {
        color: 'deep-orange',
        hue: 700,
    },
});

Vue.material.registerTheme('navigation', {
    primary: {
        color: 'cyan',
        hue: 700,
    },
    accent: {
        color: 'cyan',
        hue: 800,
    },
    warn: {
        color: 'deep-orange',
        hue: 700,
    },
});

const router = new Router({
    routes,
    mode: 'history',
    saveScrollPosition: true,
});

/* eslint-disable no-unused-vars */
const app = new Vue({
    el: '#app',
    router,
    render: h => h(App),
});
