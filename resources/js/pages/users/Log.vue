<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-12">
                    <h4 div class="text-center">Історія входу користувачів</h4>
                </div>
            </div>
        </div>

        <div>
            <vue-good-table
                :columns="columns"
                :rows="userLogs"
                :sort-options="{
                    enabled: true,
                }"
                :pagination-options="{
                    enabled: true,
                    nextLabel: 'наступна',
                    prevLabel: 'попередня',
                    rowsPerPageLabel: 'Рядки на сторінці',
                    ofLabel: 'з',
                    pageLabel: 'сторінки',
                    allLabel: 'Всі',
                    perPage: 20,
                    position: 'bottom'
                }"
                :class="table_class"
                :line-numbers="true"
                :search-options="{
                    enabled: true,
                    placeholder: 'Пошук в таблиці',
                }"
            >

                <div slot="emptystate" class="text-center">
                    Записів не знайдено
                </div>

            </vue-good-table>

        </div>
    </div>

</template>

<script>
import {VueGoodTable} from 'vue-good-table';

export default {
    name: "Log",
    components: {
        VueGoodTable,
    },
    data() {
        return {
            table_class: "table table-responsive table-hover table-sm",
            columns: [{
                label: 'Користувач',
                field: 'user_name'
            },
                {
                    label: 'IP адреса',
                    field: 'ip'
                },
                {
                    label: 'Дата входу',
                    field: 'created_at',
                    type: 'date',
                    dateInputFormat: 'yyyy-MM-dd\'T\'HH:mm:ss.SSSSSS\'Z\'',
                    dateOutputFormat: 'yyyy-MM-dd HH:mm:ss',
                    sortable: true,
                },
            ],
            userLogs: [],
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/users/log')
            .then(response => {
                this.userLogs = response.data
            });
    },
}
</script>

<style scoped>
.container-2xl {
    margin: 100px 50px;
}

a {
    color: #212529 !important;
}
</style>

<style>
/*см. invoices/Index.vue*/
</style>
