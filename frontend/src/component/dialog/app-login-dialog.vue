<template>
    <md-dialog ref="dialog">
        <md-dialog-title>Login</md-dialog-title>

        <md-dialog-content>
            <form novalidate @submit.stop.prevent="submit">
                <md-input-container>
                    <label>E-mail</label>
                    <md-input required type="email" id="email" v-model="email" name="email"></md-input>
                </md-input-container>

                <md-input-container md-has-password>
                    <label>Password</label>
                    <md-input required type="password" id="password" v-model="password" name="password"></md-input>
                </md-input-container>


            </form>
        </md-dialog-content>

        <md-dialog-actions>
            <md-button class="md-primary" @click.native="close()">Cancel</md-button>
            <md-button class="md-primary md-raised" @click.native="login()">Login</md-button>
        </md-dialog-actions>
    </md-dialog>
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
            };
        },
        methods: {
            open(onLogin) {
                this.onLogin = onLogin;

                this.$refs.dialog.open();
            },

            login() {
                this.$session.login(this.email, this.password).then(
                    () => {
                        if(this.onLogin) {
                            this.onLogin(this.model)
                        }

                        location.reload();
                    });
            },

            close() {
                if(this.onClose) {
                    this.onClose(this.model)
                }

                this.$refs.dialog.close();
            }
        }
    };
</script>


<style scoped>
    form {
        min-width: 400px;
    }
</style>