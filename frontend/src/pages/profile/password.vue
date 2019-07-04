<template>
    <div class="page-profile-password">
        <v-toolbar dark flat color="grey">
            <v-toolbar-title>Change your password</v-toolbar-title>
        </v-toolbar>

        <div class="pa-4">
            <v-form>
                <v-text-field
                        v-model="password"
                        :append-icon="show1 ? 'visibility_off' : 'visibility'"
                        :type="show1 ? 'text' : 'password'"
                        @click:append="show1 = !show1"
                        label="Old password"
                        class="old-password"
                        required
                ></v-text-field>
                <v-text-field
                        v-model="newPassword"
                        :append-icon="show2 ? 'visibility_off' : 'visibility'"
                        :type="show2 ? 'text' : 'password'"
                        @click:append="show2 = !show2"
                        label="New password"
                        class="new-password"
                        counter="8"
                        required
                ></v-text-field>
                <v-text-field
                        v-model="newPasswordAgain"
                        :append-icon="show3 ? 'visibility_off' : 'visibility'"
                        :type="show3 ? 'text' : 'password'"
                        @click:append="show3 = !show3"
                        label="New password again"
                        class="new-password-again"
                        counter="8"
                        required
                ></v-text-field>
                <v-btn depressed @click.native="save()" color="primary ml-0">Change Password</v-btn>
            </v-form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'page-profile-password',
        data() {
            return {
                'model': this.$session.getUser(),
                'password': '',
                'newPassword': '',
                'newPasswordAgain': '',
                show1: false,
                show2: false,
                show3: false,
            };
        },
        methods: {
            save() {
                this.model.changePassword(this.password, this.newPassword).then(() => {
                    this.password = '';
                    this.newPassword = '';
                    this.newPasswordAgain = '';
                    this.$alert.success('Password successfully changed');
                });
            },
        }
    };
</script>
