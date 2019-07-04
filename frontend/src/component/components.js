import AppNavigation from "./app-navigation.vue";
import AppFormFields from "./app-form-fields.vue";
import AppLoadingBar from "./app-loading-bar.vue";
import AppResultTable from "./app-result-table.vue";
import AppCreateDialog from "./dialog/app-create-dialog.vue";
import AppEditDialog from "./dialog/app-edit-dialog.vue";
import AppDeleteDialog from "./dialog/app-delete-dialog.vue";
import AppLoginDialog from "./dialog/app-login-dialog.vue";
import AppAlert from "./app-alert.vue";

const components = {};

components.install = (Vue) => {
    Vue.component("app-navigation", AppNavigation);
    Vue.component("app-form-fields", AppFormFields);
    Vue.component("app-loading-bar", AppLoadingBar);
    Vue.component("app-result-table", AppResultTable);
    Vue.component("app-create-dialog", AppCreateDialog);
    Vue.component("app-edit-dialog", AppEditDialog);
    Vue.component("app-delete-dialog", AppDeleteDialog);
    Vue.component("app-login-dialog", AppLoginDialog);
    Vue.component("app-alert", AppAlert);
};

export default components;