<template>
    <div class="profile">
        <form>
            <app-form-fields :form="form"></app-form-fields>
        </form>

        <md-button class="md-primary md-raised" @click.native="save()">Save</md-button>
    </div>
</template>

<script>
    import User from 'model/user';
    import Form from 'common/form';

    export default {
        name: 'profile',
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
