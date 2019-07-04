<template>
    <div class="app-navigation">
        <v-toolbar dark color="grey darken-2" class="hidden-lg-and-up" @click.stop="showNavigation()">
            <v-toolbar-side-icon></v-toolbar-side-icon>

            <v-toolbar-title>Symlex</v-toolbar-title>

            <v-spacer></v-spacer>
        </v-toolbar>
        <v-navigation-drawer
                v-model="drawer"
                :mini-variant="mini"
                fixed
                app
                class="blue-grey lighten-5"
                width="270"
        >
            <v-toolbar flat dark class="grey darken-1">
                <v-list>
                    <v-list-tile>
                        <v-list-tile-avatar>
                            <img src="/img/logo.png">
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-title class="title">{{ $config.appName }}</v-list-tile-title>
                        </v-list-tile-content>
                        <v-list-tile-action class="hidden-md-and-down">
                            <v-btn icon @click.stop="mini = !mini">
                                <v-icon>chevron_left</v-icon>
                            </v-btn>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>
            </v-toolbar>

            <v-list class="pt-3">
                <v-list-tile v-if="mini" @click.stop="mini = !mini">
                    <v-list-tile-action>
                        <v-icon>chevron_right</v-icon>
                    </v-list-tile-action>
                </v-list-tile>

                <v-list-tile to="/welcome" @click="">
                    <v-list-tile-action>
                        <v-icon class="navHome">home</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Home</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAnonymous()" to="/register" @click="">
                    <v-list-tile-action>
                        <v-icon class="navRegister">person</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Register</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAnonymous()" to="/" @click.native="login()">
                    <v-list-tile-action>
                        <v-icon class="navLogin">lock_open</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Login</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAdmin()" to="/users" @click="">
                    <v-list-tile-action>
                        <v-icon class="navUsers">group</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>User Management</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isUser()" to="/profile/details" @click="">
                    <v-list-tile-action>
                        <v-icon class="navUserEdit">face</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>My Profile</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAdmin()" to="/profile/password" @click="">
                    <v-list-tile-action>
                        <v-icon class="navUserPassword">lock</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Change Password</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isUser()" to="/" @click.native="logout()">
                    <v-list-tile-action>
                        <v-icon class="navLogout">exit_to_app</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Logout</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>

        </v-navigation-drawer>

        <app-login-dialog ref="loginDialog"></app-login-dialog>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                drawer: null,
                items: [
                    {title: 'Welcome', route: 'welcome', icon: 'dashboard'},
                    {title: 'Register', route: 'register'},
                    {title: 'Users', route: 'users'},
                    {title: 'Profile', route: 'profile/details'},
                    {title: 'Change Password', route: 'profile/password'},
                ],
                mini: false,
            };
        },
        methods: {
            showNavigation: function () {
                this.drawer = true;
                this.mini = false;
                console.log(this.$router.currentRoute);
            },

            toggleLeftSidenav() {
                this.$refs.leftSidenav.toggle();
            },

            open(ref) {
            },

            close(ref) {
            },

            login() {
                this.$refs.loginDialog.open();
            },

            register() {
                this.$router.push({path: 'register'})
            },

            logout() {
                this.$session.logout();
            },
        }
    };
</script>
