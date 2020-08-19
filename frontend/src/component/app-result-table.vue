<template>
    <div class="app-result-table">
        <v-data-table
            :headers="headers"
            :items="rows"
            :total-items="resultTotal"
            class="elevation-0"
            :pagination.sync="pagination"
            :rows-per-page-items="pageOptions"
            item-key="id"
        >
            <template slot="items" slot-scope="props">
                <td v-for="(column, colIndex) in columns" :key="colIndex">
                    {{ typeof props.item[column.value] === 'function' ? props.item[column.value]() : props.item[column.value]}}
                </td>
                <td v-if="actions" class="justify-center layout px-0">
                    <v-btn fab flat small v-for="action in actions" :key="action.name"
                           @click.native="performAction(action.name, props.item)">
                        <v-icon small>
                            {{ action.name }}
                        </v-icon>
                    </v-btn>
                </td>
            </template>
        </v-data-table>

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
            const resultOffset = parseInt(resultCount * (resultPage - 1));
            const order = query.hasOwnProperty('order') ? query['order'] : '';
            const dir = query.hasOwnProperty('dir') ? query['dir'] : '';
            const headers = this.columns.slice(0);

            if (this.actions.length > 0) {
                headers.push({text: 'Actions', sortable: false, value: 'actions', align: 'center'})
            }

            return {
                'rows': [],
                'page': resultPage,
                'headers': headers,
                'order': order,
                'dir': dir,
                'pagination': {
                    rowsPerPage: 20,
                    sortBy: "",
                },
                'pageOptions': [10, 20, 50, 100],
                'resultCount': resultCount,
                'resultOffset': resultOffset,
                'resultTotal': 0,
                'lastQuery': {},
                'submitTimeout': false,
            }
        },
        watch: {
            pagination: {
                handler() {
                    this.onPagination();
                },
                deep: true
            }
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
            onPagination() {
                const {sortBy, descending, page, rowsPerPage} = this.pagination;
                this.page = parseInt(page);
                this.resultCount = parseInt(rowsPerPage);
                this.order = sortBy;
                this.dir = descending ? 'DESC' : 'ASC';
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
                    count: parseInt(this.resultCount < 0 ? 1000 : this.resultCount),
                    offset: parseInt(this.resultCount * (this.page - 1)),
                    order: this.order !== '' ? this.order + ' ' + this.dir : '',
                };

                Object.assign(params, this.query);

                // Don't query the same data more than once
                if (JSON.stringify(this.lastQuery) === JSON.stringify(params)) {
                    return;
                }

                this.lastQuery = params;

                // Set URL hash
                const urlParams = {
                    count: this.resultCount.toString(),
                    page: this.page.toString(),
                    order: this.order.toString(),
                    dir: this.dir.toString(),
                };

                Object.assign(urlParams, this.query);

                if (JSON.stringify(this.$route.query) !== JSON.stringify(urlParams)) {
                    this.$router.replace({query: urlParams});
                }

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