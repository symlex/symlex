<template>
    <v-dialog v-model="show" max-width="600">
        <v-card class="pa-1">
            <v-card-title class="title">Login</v-card-title>

            <v-card-text>

                <v-form novalidate @submit.stop.prevent="submit">
                    <v-text-field required type="email" id="email" v-model="email" name="email"
                                  label="E-Mail"></v-text-field>
                    <v-text-field required type="password" id="password" v-model="password" name="password"
                                  label="Password"></v-text-field>
                </v-form>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed color="secondary" class="black--text" id="cancelLogin" @click.native="close()">Cancel</v-btn>
                <v-btn depressed color="primary" id="login" @click.native="login()">Login</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Form from 'common/form';
    import User from 'model/user';

    export default {
        name: 'app-login-dialog',
        data() {
            return {
                'email': '',
                'password': '',
                'model': User,
                'form': new Form(),
                'onLogin': false,
                'onClose': false,
                'show': false
            };
        },
        methods: {
            open(onLogin) {
                this.onLogin = onLogin;

                this.show = true;
            },

            login() {
                this.$session.login(this.email, this.password).then(
                    () => {
                        if (this.onLogin) {
                            this.onLogin(this.model)
                        }

                        location.reload();
                    });
            },

            close() {
                if (this.onClose) {
                    this.onClose(this.model)
                }

                this.show = false;
            }
        }
    };
</script>