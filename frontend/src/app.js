// JavaScript
import Vue from "vue";
import Vuetify from "vuetify";
import Router from "vue-router";
import App from "app.vue";
import routes from "routes";
import Api from "common/api";
import Components from "component/components";
import Alert from "common/alert";
import Session from "common/session";
import Event from "pubsub-js";
import Moment from "vue-moment";

// CSS
import "./css/app.css";

// Initialize helpers
const session = new Session(window.localStorage);

// Assign helpers to VueJS prototype
Vue.prototype.$event = Event;
Vue.prototype.$alert = Alert;
Vue.prototype.$session = session;
Vue.prototype.$api = Api;
Vue.prototype.$config = window.appConfig;

// Register Vuetify
Vue.use(Vuetify, {
    theme: {
        primary: "#607D8B",
        secondary: "#EEEEEE",
        accent: "#546E7A",
        error: "#E57373",
        info: "#00B8D4",
        success: "#00BFA5",
        warning: "#E64A19",
        delete: "#E57373",
    },
});

// Register other VueJS plugins
Vue.use(Moment);
Vue.use(Components);
Vue.use(Router);

// Configure client-side routing
const router = new Router({
    routes,
    mode: "history",
    saveScrollPosition: true,
});

// Run app
/* eslint-disable no-unused-vars */
const app = new Vue({
    el: "#app-container",
    router,
    render: h => h(App),
});
