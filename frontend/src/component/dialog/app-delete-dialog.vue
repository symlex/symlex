<template>
    <v-dialog v-model="show" max-width="600">
        <v-card class="pa-1">
            <v-card-title class="title">Delete {{ modelName }}</v-card-title>

            <v-card-text>
                Are you sure you want to delete "{{ entityName }}"?
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed color="secondary" class="black--text" id="cancelDelete" @click.native="close()">Cancel</v-btn>
                <v-btn depressed color="primary" raised @click.native="confirm()">Delete</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: 'app-delete-dialog',
        data() {
            return {
                'model': false,
                'modelName': 'Item',
                'entityName': 'this item',
                'onConfirm': false,
                'show': false,
            };
        },
        methods: {
            open(model, onConfirm) {
                this.model = model;
                this.modelName = model.constructor.getModelName();
                this.entityName = model.getEntityName();
                this.onConfirm = onConfirm;

                this.show = true;
            },
            close() {
                this.show = false;
            },
            confirm() {
                if (this.onConfirm) {
                    this.onConfirm()
                }
            }
        }
    };
</script>