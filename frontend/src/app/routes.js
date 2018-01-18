import Welcome from 'app/pages/welcome.vue';
import Users from 'app/pages/users.vue';
import Profile from 'app/pages/profile.vue';

export default [
    { path: '/', redirect: '/welcome' },
    { path: '/welcome', component: Welcome },
    { path: '/profile', component: Profile },
    { path: '/users', component: Users },
    { path: '*', redirect: '/welcome' },
];
