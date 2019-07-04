<template>
    <div class="page-profile-details">
        <v-toolbar dark flat color="grey">
            <v-toolbar-title>Change your personal details</v-toolbar-title>
        </v-toolbar>

        <div class="pa-4">
            <form>
                <app-form-fields :form="form"></app-form-fields>
            </form>
            <v-btn depressed color="primary ml-0" @click.native="save()">Save</v-btn>
        </div>
    </div>
</template>

<script>
    import User from 'model/user';
    import Form from 'common/form';

    export default {
        name: 'page-profile-details',
        data() {
            return {
                'model': this.$session.getUser(),
                'form': new Form(),
            };
        },
        methods: {
            save() {
                this.model.setValues(this.form.getValues()).saveProfile().then(user => {
                    this.form.setValues(user.getValues());
                    this.$alert.success('Profile successfully saved');
                });
            },
        },
        mounted() {
            this.model.getProfileForm().then(response => this.form = response);
        }
    };
</script>
