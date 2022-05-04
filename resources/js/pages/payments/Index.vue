<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8">
                    <h4 class="text-center">Перелік платежів</h4>
                </div>
            </div>
        </div>

        <div>
            <vue-good-table
                :columns="columns"
                :rows="payments"
                :search-options="{ enabled: true }"
                :pagination-options="{enabled: true}"
                :class="table_class">
            </vue-good-table>

        </div>
    </div>

</template>

<script>
import {VueGoodTable} from 'vue-good-table';

export default {
    components: {
        VueGoodTable,
    },
    name: "Index",
    data() {
        return {
            table_class: "table table-responsive table-hover table-sm",
            columns: [{
                label: 'Контрагент',
                field: 'firm.firm_name'
            },
                {
                    label: 'Сума',
                    field: 'amount'
                },
                {
                    label: 'Дата',
                    field: 'date'
                },
            ],
            payments: [],
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/payments')
            .then(response => {
                this.payments = response.data;
            });
    },
}
</script>

<style scoped>
.container-2xl {
    margin: 100px 50px;
}

table {
    width: 100%;
    word-break: break-word;
}
</style>
