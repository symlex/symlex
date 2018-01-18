<template>
    <div class="app-form">
        <template v-for="(field, fieldName) in form.getDefinition()">
            <md-input-container v-if="!field.hidden && field.type != 'bool'" :key="fieldName">
                <label>{{ field.caption }}</label>
                <template v-if="field.options">
                    <md-select v-if="field.type == 'string' && field.options" :required="field.required"
                               v-model="field.value">
                        <md-option v-for="status in field.options" :value="status.option" :key="status.option">
                            {{ status.label }}
                        </md-option>
                    </md-select>
                </template>
                <template v-else>
                    <md-input v-if="field.type == 'email' || field.type == 'string'" :required="field.required"
                              v-model="field.value"></md-input>

                </template>
            </md-input-container>

            <md-checkbox v-if="field.type == 'bool'" :id="field.uid" v-model="field.value">{{ field.caption }}</md-checkbox>
        </template>
    </div>
</template>

<script>
    export default {
        name: 'app-form-fields',
        props: {
            form: {
                type: Object
            }
        },
    };
</script>

<style scoped>
</style>
