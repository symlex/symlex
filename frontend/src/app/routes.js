import Welcome from 'app/pages/welcome.vue';
import Users from 'app/pages/users.vue';
import ProfileDetails from 'app/pages/profile/details.vue';
import ProfilePassword from 'app/pages/profile/password.vue';
import Register from 'app/pages/register.vue';
import RegisterConfirm from 'app/pages/register-confirm.vue';

export default [
    {
        path: '/',
        redirect: '/welcome',
    },
    {
        name: 'welcome',
        path: '/welcome',
        component: Welcome,
        meta: {area: 'Home'},
    },
    {
        name: 'profile_details',
        path: '/profile/details',
        component: ProfileDetails,
        meta: {area: 'Settings'},
    },
    {
        name: 'profile_password',
        path: '/profile/password',
        component: ProfilePassword,
        meta: {area: 'Settings'},
    },
    {
        name: 'users',
        path: '/users',
        component: Users,
        meta: {area: 'Admin'},
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta: {area: 'Register'},
    },
    {
        name: 'register_confirm',
        path: '/register/confirm/:token',
        component: RegisterConfirm,
        meta: {area: 'Register'},
    },
    {
        path: '*',
        redirect: '/welcome'
    },
];
