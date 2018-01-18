<template>
    <div class="app-navigation">
        <md-toolbar md-theme="navigation">
            <md-button class="md-icon-button" @click.native="toggleLeftSidenav">
                <md-icon>menu</md-icon>
            </md-button>

            <h2 class="md-title">{{ $config.appName }}</h2>

            <span style="flex: 1"></span>

            <md-button v-if="$session.isAnonymous()" @click.native="login()" class="md-raised md-accent">Login
            </md-button>
            <md-button v-if="$session.isUser()" @click.native="logout()" class="md-raised md-accent">Logout {{ $session.getFirstName() }}</md-button>
        </md-toolbar>

        <md-sidenav class="md-left md-fixed" ref="leftSidenav" :md-swipeable="true" @open="open('Left')"
                    @close="close('Left')">
            <md-list>
                <md-list-item @click.native="$refs.leftSidenav.toggle()">
                    <router-link to="/welcome">Welcome</router-link>
                </md-list-item>

                <md-list-item v-if="$session.isAdmin()" @click.native="$refs.leftSidenav.toggle()">
                    <router-link to="/users">Users</router-link>
                </md-list-item>

                <md-list-item v-if="$session.isUser()" @click.native="$refs.leftSidenav.toggle()">
                    <router-link to="/profile">Profile</router-link>
                </md-list-item>
            </md-list>
        </md-sidenav>

        <app-login-dialog ref="loginDialog"></app-login-dialog>
    </div>
</template>

<script>
    export default {
        data() {
            return {};
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

            logout() {
                this.$session.logout();
            },
        }
    };
</script>

<style scoped>
</style>
