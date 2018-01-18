<template>
    <md-dialog ref="dialog">
        <md-dialog-title>Edit {{ modelName }}</md-dialog-title>

        <md-dialog-content>
            <form>
                <app-form-fields :form="form"></app-form-fields>
            </form>
        </md-dialog-content>

        <md-dialog-actions>
            <md-button class="md-primary" @click.native="close()">Cancel</md-button>
            <md-button class="md-primary md-raised" @click.native="save()">Save</md-button>
        </md-dialog-actions>
    </md-dialog>
</template>

<script>
    import Form from 'common/form';

    export default {
        name: 'app-edit-dialog',
        data() {
            return {
                'model': false,
                'modelName': 'Item',
                'entityName': 'this item',
                'form': new Form(),
                'onSave': false
            };
        },
        methods: {
            open(model, form, onSave) {
                this.model = model;
                this.modelName = model.constructor.getModelName();
                this.entityName = model.getEntityName();
                this.form = form;
                this.onSave = onSave;

                this.$refs.dialog.open();
            },
            save() {
                if(this.onSave) {
                    this.onSave(this.form)
                }
            },
            close() {
                this.$refs.dialog.close();
            }
        }
    };
</script>


<style scoped>
    form {
        min-width: 400px;
    }
</style>