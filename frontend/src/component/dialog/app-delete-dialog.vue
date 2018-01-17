<template>
    <md-dialog ref="dialog">
        <md-dialog-title>Delete {{ modelName }}</md-dialog-title>

        <md-dialog-content>
            Are you sure you want to delete "{{ entityName }}"?
        </md-dialog-content>

        <md-dialog-actions>
            <md-button class="md-primary" @click.native="close()">Cancel</md-button>
            <md-button class="md-primary md-raised" @click.native="confirm()">Delete</md-button>
        </md-dialog-actions>
    </md-dialog>
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
            };
        },
        methods: {
            open(model, onConfirm) {
                this.model = model;
                this.modelName = model.constructor.getModelName();
                this.entityName = model.getEntityName();
                this.onConfirm = onConfirm;

                this.$refs.dialog.open();
            },
            close() {
                this.$refs.dialog.close();
            },
            confirm() {
                if(this.onConfirm) {
                    this.onConfirm()
                }
            }
        }
    };
</script>