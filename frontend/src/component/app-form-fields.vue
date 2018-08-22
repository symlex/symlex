<template>
    <div class="app-form">
        <template v-for="(field, fieldName) in form.getDefinition()">
            <input v-if="field.hidden" type="hidden" :name="fieldName" :value="field.value" />
            <div v-else-if="field.image" class="image">
                <img :src="field.value" />
            </div>
            <md-input-container v-else-if="field.password && field.type === 'string'" md-has-password :key="fieldName">
                <label>{{ field.caption }}</label>
                <md-input :required="field.required" type="password" v-model="field.value"></md-input>
            </md-input-container>
            <md-input-container v-else-if="field.type !== 'bool'" :key="fieldName">
                <label>{{ field.caption }}</label>
                <template v-if="field.options">
                    <label>{{ field.caption }}</label>
                    <md-select v-if="field.type == 'string' && field.options" :required="field.required"
                               v-model="field.value" :readonly="field.readonly">
                        <md-option v-for="status in field.options" :value="status.option" :key="status.option">
                            {{ status.label }}
                        </md-option>
                    </md-select>
                </template>
                <template v-else>
                    <md-input v-if="field.type == 'email' || field.type === 'string'" :required="field.required"
                              v-model="field.value" :readonly="field.readonly"></md-input>

                </template>
            </md-input-container>
            <md-checkbox v-else-if="field.type === 'bool'" :id="field.uid" v-model="field.value">{{ field.caption }}</md-checkbox>
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
    div.image {
        margin: 10px 0 0 0;
    }
</style>
