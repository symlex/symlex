<template>
    <div class="page-register">
        <v-toolbar dark flat color="grey">
            <v-toolbar-title>Create new account</v-toolbar-title>
        </v-toolbar>

        <div class="pa-4">
            <div v-if="success">
                <h2>Thank you for signing up!</h2>
                <p>Please confirm your email address <em>{{ model.userEmail }}</em> by visiting the link your received.
                </p>
                <p>Note: When running this app with docker-compose, you can see all outgoing mails at <a
                        href="http://localhost:8082/" target="_blank">http://localhost:8082/</a> (for development and
                    testing only).</p>
            </div>
            <form v-else>
                <app-form-fields :form="form"></app-form-fields>

                <v-btn color="primary" @click.native="save()" class="ml-0">Sign Up</v-btn>
            </form>
        </div>
    </div>
</template>

<script>
    import Registration from 'model/registration';
    import Form from 'common/form';

    export default {
        name: 'page-register',
        data() {
            return {
                'model': new Registration(),
                'form': new Form(),
                'success': false,
            };
        },
        methods: {
            save() {
                this.model.setValues(this.form.getValues()).save().then(registration => {
                    this.model.setValues(registration);
                    this.success = true;
                });
            },
        },
        mounted() {
            Registration.getCreateForm().then(response => this.form = response);
        }
    };
</script>
