<template>
    <div class="app-navigation">

        <v-navigation-drawer
                v-model="drawer"
                :mini-variant="mini"
                fixed
                app
                class="cyan lighten-5"
                width="250"
                permanent
        >
            <v-toolbar flat dark class="pb-2 blue-grey darken-1">
                <v-list class="pb-2">
                    <v-list-tile avatar>
                        <v-list-tile-avatar>
                            <v-icon medium>fas fa-dice-d20</v-icon>
                        </v-list-tile-avatar>

                        <v-list-tile-content>
                            <v-list-tile-title class="title">{{ $config.appName }}</v-list-tile-title>
                        </v-list-tile-content>

                        <v-list-tile-action>
                            <v-btn
                                    icon
                                    @click.stop="mini = !mini"
                            >
                                <v-icon>chevron_left</v-icon>
                            </v-btn>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>
            </v-toolbar>

            <v-list>

                <v-list-tile v-if="mini" @click.stop="mini = !mini">
                    <v-list-tile-action>
                        <v-icon>chevron_right</v-icon>
                    </v-list-tile-action>
                </v-list-tile>

                <v-list-tile to="/welcome" @click="">
                    <v-list-tile-action>
                        <v-icon small class="navHome">fa-home</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Welcome</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAnonymous()" to="/register" @click="">
                    <v-list-tile-action>
                        <v-icon small class="navRegister">fa-edit</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Register</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAnonymous()" to="loginDialog" @click.native="login()">
                    <v-list-tile-action>
                        <v-icon small class="navLogin">fas fa-sign-in-alt</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Login</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAdmin()" to="/users" @click="">
                    <v-list-tile-action>
                        <v-icon small class="navUsers">fa-users</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>User Management</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAdmin()" to="/profile/details" @click="">
                    <v-list-tile-action>
                        <v-icon small class="navUserEdit">fas fa-user-edit</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Edit Profile</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isAdmin()" to="/profile/password" @click="">
                    <v-list-tile-action>
                        <v-icon small class="navUserPassword">fas fa-user-lock</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Change Password</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-list-tile v-if="$session.isUser()" to="/" @click.native="logout()">
                    <v-list-tile-action>
                        <v-icon small class="navLogout">fas fa-sign-out-alt</v-icon>
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
                drawer: true,
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

<style scoped>
</style>
