<template>
    <v-dialog v-model="show" max-width="600">
        <v-card class="pa-1">
            <v-card-title class="title">Edit {{ modelName }}</v-card-title>

            <v-card-text>
                <v-form>
                    <app-form-fields :form="form"></app-form-fields>
                </v-form>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed color="secondary" class="black--text" id="cancelEdit" @click.native="close()">Cancel</v-btn>
                <v-btn depressed color="primary" raised @click.native="save()">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
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
                'onSave': false,
                'show': false,
            };
        },
        methods: {
            open(model, form, onSave) {
                this.model = model;
                this.modelName = model.constructor.getModelName();
                this.entityName = model.getEntityName();
                this.form = form;
                this.onSave = onSave;

                this.show = true;
            },
            save() {
                if (this.onSave) {
                    this.onSave(this.form)
                }
            },
            close() {
                this.show = false;
            }
        }
    };
</script>