<template>
    <div class="users">
        <v-toolbar flat color="blue-grey lighten-4">
            <v-toolbar-title>User Management</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn fab small color="accent" @click="$refs.list.showCreateDialog()">
                <v-icon class="addUser">add</v-icon>
            </v-btn>
        </v-toolbar>

        <div class="pa-4">
            <app-result-table
                    ref="list"
                    :query="query"
                    :actions="actions"
                    :model="model"
                    :columns="columns"
            >
            </app-result-table>
        </div>
    </div>
</template>

<script>
    import User from 'model/user';

    export default {
        name: 'users',
        data() {
            return {
                query: {},
                model: User,
                columns: [
                    {value: "userId", text: "ID"},
                    {value: "userEmail", text: "E-Mail"},
                    {value: "userFirstName", text: "First Name"},
                    {value: "userLastName", text: "Last Name"},
                ],
                actions: [
                    {name: "delete", label: "Delete"},
                    {name: "edit", label: "Edit"},
                ]
            };
        }
    };
</script>
