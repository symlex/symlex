<template>
    <div class="app-result-table">
        <md-table @select="onSelect" @sort="onSort" :md-sort="order" :md-sort-type="dir">
            <md-table-header>
                <md-table-row>
                    <md-table-head v-for="(column, colIndex) in columns" :key="colIndex" :md-sort-by="column.name">
                        {{ column.label }}
                    </md-table-head>
                    <md-table-head v-if="actions"></md-table-head>
                </md-table-row>
            </md-table-header>

            <md-table-body>
                <md-table-row v-for="(item, rowIndex) in rows" :key="rowIndex" :md-selection="selectable">
                    <md-table-cell v-for="(column, colIndex) in columns" :key="colIndex">{{ item[column.name] }}
                    </md-table-cell>
                    <md-table-cell v-if="actions" md-numeric>
                        <md-button class="md-icon-button" v-for="(action, index) in actions" :key="action.name"
                                   @click.native="performAction(action.name, item)">
                            <md-icon>{{ action.name }}</md-icon>
                        </md-button>
                    </md-table-cell>
                </md-table-row>
            </md-table-body>
        </md-table>

        <app-table-pagination
                :md-size="resultCount"
                :md-total="resultTotal"
                :md-page="page"
                md-label="Rows"
                md-separator="of"
                :md-page-options="pageOptions"
                @pagination="onPagination"></app-table-pagination>

        <app-delete-dialog ref="deleteDialog"></app-delete-dialog>
        <app-edit-dialog ref="editDialog"></app-edit-dialog>
        <app-create-dialog ref="createDialog"></app-create-dialog>
    </div>
</template>

<script>
    import Form from 'common/form';

    import _ from 'lodash/lang';

    export default {
        name: 'app-result-table',
        props: {
            selectable: {
                type: Boolean,
                default: false
            },

            model: {
                type: Function,
            },

            query: {
                type: Object,
                default: {}
            },

            columns: {
                type: Array
            },

            actions: {
                type: Array
            },
        },
        data() {
            const query = this.$route.query;
            const resultCount = query.hasOwnProperty('count') ? parseInt(query['count']) : 15;
            const resultPage = query.hasOwnProperty('page') ? parseInt(query['page']) : 1;
            const resultOffset = resultCount * (resultPage - 1);
            const order = query.hasOwnProperty('order') ? query['order'] : '';
            const dir = query.hasOwnProperty('dir') ? query['dir'] : '';

            return {
                'rows': [],
                'page': resultPage,
                'order': order,
                'dir': dir,
                'pageOptions': [15, 30, 50, 100],
                'resultCount': resultCount,
                'resultOffset': resultOffset,
                'resultTotal': 'Many',
                'lastQuery': {},
                'submitTimeout': false,
            };
        },
        methods: {
            deleteEntity(instance) {
                instance.remove().then(() => {
                    this.$refs.deleteDialog.close();
                    this.lastQuery = {};
                    this.$alert.success(this.model.getModelName() + ' successfully deleted');
                    this.refreshList();
                }).catch(() => this.$refs.deleteDialog.close());
            },
            updateEntity(instance, form) {
                instance.setValues(form.getValues()).update().then(response => {
                    this.$refs.editDialog.close();
                    this.lastQuery = {};
                    this.$alert.success(this.model.getModelName() + ' successfully saved');
                    this.refreshList();
                });
            },
            createEntity(form) {
                const instance = new this.model;
                instance.setValues(form.getValues()).save().then(response => {
                    this.$refs.createDialog.close();
                    this.lastQuery = {};
                    this.$alert.success(this.model.getModelName() + ' successfully saved');
                    this.refreshList();
                });
            },
            showCreateDialog() {
                this.model.getCreateForm().then(form => this.$refs.createDialog.open(this.model, form, (form) => this.createEntity(form)));
            },
            showDeleteDialog(instance) {
                this.$refs.deleteDialog.open(instance, () => this.deleteEntity(instance));
            },
            showEditDialog(instance) {
                instance.getEditForm().then(form => this.$refs.editDialog.open(instance, form, (form) => this.updateEntity(instance, form)));
            },
            performAction(action, instance) {
                switch (action) {
                    case 'delete':
                        this.showDeleteDialog(instance);
                        break;
                    case 'edit':
                        this.showEditDialog(instance);
                        break;
                    default:
                        this.$alert.warn('Invalid action: ' + action);
                }
            },
            onPagination(pagination) {
                this.page = parseInt(pagination.page);
                this.resultCount = parseInt(pagination.size);
                this.refreshList();
            },
            onSort(sort) {
                this.order = sort.name;
                this.dir = sort.type;
                this.refreshList();
            },
            onSelect() {
                console.log('Select', arguments);
            },
            debounceRefreshList() {
                if (this.submitTimeout) {
                    clearTimeout(this.submitTimeout);
                }

                this.submitTimeout = setTimeout(this.refreshList, 1000);
            },
            refreshList() {
                // Compose query parameters
                const params = {
                    count: this.resultCount,
                    offset: this.resultCount * (this.page - 1),
                    order: this.order !== '' ? this.order + ' ' + this.dir : '',
                };

                Object.assign(params, this.query);

                // Don't query the same data more than once
                if (_.isEqual(this.lastQuery, params)) return;

                this.lastQuery = params;

                // Set URL hash
                const urlParams = {
                    count: this.resultCount,
                    page: this.page,
                    order: this.order,
                    dir: this.dir
                };

                Object.assign(urlParams, this.query);

                this.$router.replace({query: urlParams});

                this.model.search(params).then(response => {
                    this.resultTotal = parseInt(response.headers['x-result-total']);
                    this.resultCount = parseInt(response.headers['x-result-count']);
                    this.resultOffset = parseInt(response.headers['x-result-offset']);
                    this.rows = response.models;
                });
            }
        },
        created() {
            this.refreshList();
        },
    };
</script>

<style scoped>
    h1 {
        font-weight: bold;
    }
</style>