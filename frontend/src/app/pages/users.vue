<template>
    <div class="users">
        <md-table-card>
            <md-toolbar>
                <h1 class="md-title">Users</h1>
                <md-button class="md-icon-button">
                    <md-icon @click.native="$refs.list.showCreateDialog()">add</md-icon>
                </md-button>
            </md-toolbar>
        <app-result-table
                ref="list"
                :query="query"
                :actions="actions"
                :model="model"
                :columns="columns">
        </app-result-table>
        </md-table-card>
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
                    {name: "userId", label: "ID"},
                    {name: "userEmail", label: "E-Mail"},
                    {name: "userFirstName", label: "First Name"},
                    {name: "userLastName", label: "Last Name"},
                ],
                actions: [
                    {name: "delete", label: "Delete"},
                    {name: "edit", label: "Edit"},
                ]
            };
        }
    };
</script>
