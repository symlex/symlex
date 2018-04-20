<template>
    <div class="change-password">
        <form novalidate @submit.stop.prevent="submit">
            <md-input-container>
                <label>Old password</label>
                <md-input required type="password" id="password" v-model="password" name="password"></md-input>
            </md-input-container>

            <md-input-container>
                <label>New password</label>
                <md-input required type="password" id="new-password" v-model="newPassword" name="newPassword"></md-input>
            </md-input-container>

            <md-input-container>
                <label>New password again</label>
                <md-input required type="password" id="new-password-again" v-model="newPasswordAgain" name="newPasswordAgain"></md-input>
            </md-input-container>
        </form>

        <md-button class="md-primary md-raised" @click.native="save()">Change Password</md-button>
    </div>
</template>

<script>
    import User from 'model/user';

    export default {
        name: 'change-password',
        data() {
            return {
                'model': this.$session.getUser(),
                'password': '',
                'newPassword': '',
                'newPasswordAgain': '',
            };
        },
        methods: {
            save() {
                console.log(this.model);
                this.model.changePassword(this.password, this.newPassword).then(response => {
                    this.password = '';
                    this.newPassword = '';
                    this.newPasswordAgain = '';
                    this.$alert.success('Password successfully changed');
                });
            },
        }
    };
</script>
