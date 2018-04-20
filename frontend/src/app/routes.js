import Welcome from 'app/pages/welcome.vue';
import Users from 'app/pages/users.vue';
import ProfileDetails from 'app/pages/profile/details.vue';
import ProfilePassword from 'app/pages/profile/password.vue';

export default [
    { path: '/', redirect: '/welcome' },
    { path: '/welcome', component: Welcome },
    { path: '/profile/details', component: ProfileDetails },
    { path: '/profile/password', component: ProfilePassword },
    { path: '/users', component: Users },
    { path: '*', redirect: '/welcome' },
];
