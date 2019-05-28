<template>
    <div class="app-form">
        <template v-for="(field, fieldName) in form.getDefinition()">
            <v-form>
                <input v-if="field.hidden" type="hidden" :name="fieldName" :value="field.value" />
                <div v-else-if="field.image" class="image">
                    <img class="mt-1" :src="field.value" />
                </div>
                <v-text-field v-else-if="field.password && field.type === 'string'" :key="fieldName" :label="field.caption" :required="field.required" type="password" v-model="field.value">
                </v-text-field>
               <template v-else-if="field.type !== 'bool'">
                    <template v-if="field.options">
                        <v-select v-if="field.type == 'string' && field.options" :required="field.required" :label="field.caption"
                                    v-model="field.value" :readonly="field.readonly" :items="field.options" item-text="label" item-value="option">
                         </v-select>
                    </template>
                    <template v-else>
                        <v-text-field v-if="field.type == 'email' || field.type === 'string'" :required="field.required" v-model="field.value" :readonly="field.readonly" :label="field.caption"></v-text-field>

                    </template>
                </template>
                <v-checkbox v-else-if="field.type === 'bool'" :id="field.uid" v-model="field.value" :label="field.caption"></v-checkbox>
            </v-form>
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