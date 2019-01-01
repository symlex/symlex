import Welcome from 'app/pages/welcome.vue';
import Users from 'app/pages/users.vue';
import ProfileDetails from 'app/pages/profile/details.vue';
import ProfilePassword from 'app/pages/profile/password.vue';
import Register from 'app/pages/register.vue';
import RegisterConfirm from 'app/pages/register-confirm.vue';

export default [
    { name: 'Home', path: '/', redirect: '/welcome' },
    { name: 'Home', path: '/welcome', component: Welcome },
    { name: 'Settings', path: '/profile/details', component: ProfileDetails },
    { name: 'Settings', path: '/profile/password', component: ProfilePassword },
    { name: 'Admin', path: '/users', component: Users },
    { name: 'Register', path: '/register', component: Register },
    { name: 'Register', path: '/register/confirm/:token', component: RegisterConfirm },
    { path: '*', redirect: '/welcome' },
];
