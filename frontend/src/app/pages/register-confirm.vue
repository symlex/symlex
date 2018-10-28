<template>
    <div class="profile">
        <p><strong>Please choose a password to complete your registration (minimum 8 characters):</strong></p>
        <form>
            <app-form-fields :form="form"></app-form-fields>
            <v-btn color="primary" @click.native="save()">Complete Sign Up</v-btn>
        </form>
    </div>
</template>

<script>
    import Registration from 'model/registration';
    import Form from 'common/form';

    export default {
        name: 'register-confirm',
        data() {
            return {
                'model': new Registration(),
                'form': new Form(),
            };
        },
        methods: {
            save() {
                this.model.sendConfirmForm(this.$route.params.token, this.form).then(() => {
                    this.login();
                });
            },
            login() {
                this.$session.login(this.form.getValue('userEmail'), this.form.getValue('password')).then(() => window.location = '/');
            },
        },
        mounted() {
            this.model.getConfirmForm(this.$route.params.token).then(response => this.form = response);
        },
    };
</script>
