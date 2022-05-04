<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <h4 class="text-center">Акти</h4>
                </div>
                <div class="col-sm-3 text-right">

                    <date-range-picker
                        ref="picker"
                        v-model="tableFilter.dates"
                        :locale-data="locale"
                        :opens="'left'"
                        :appendToBody="true"
                        :ranges="ranges">

                        <div slot="header" slot-scope="header" class="slot">
                            <h6><b>Інтервал дат актів для фільтрації</b></h6>
                        </div>

                    </date-range-picker>

                    <download-excel
                        class="download-excel"
                        :data="actsForTable"
                        :fields="json_fields"
                        :name="fileName"
                        :stringifyLongNum="true">
                        <button type="button" class="btn btn-outline-secondary">
                            Excel
                            <fa-layer class="fa-1x">
                                <fa-icon :icon="['fa', 'download']" style="color:grey; cursor:pointer;"/>
                            </fa-layer>
                        </button>
                    </download-excel>
                </div>

            </div>
        </div>

        <div>
            <vue-good-table
                :columns="columns"
                :rows="actsForTable"
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
                    perPage: 30,
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

                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field === 'Назва контрагента (скорочена)'">
                        <router-link :to="{name: 'firms.show', params: { id: props.row.firm_id }}" :title="'Детально'">
                            {{ props.row.firm_name_short }}
                        </router-link>
                    </span>
                </template>

            </vue-good-table>

        </div>
    </div>

</template>

<script>
import {VueGoodTable} from 'vue-good-table';
import DateRangePicker from 'vue2-daterange-picker';

export default {
    name: "Index",
    components: {
        VueGoodTable,
        DateRangePicker
    },
    data() {
        let today = new Date()
        today.setHours(0, 0, 0, 0)
        let yesterday = new Date()
        yesterday.setDate(today.getDate() - 1)
        yesterday.setHours(0, 0, 0, 0);
        return {
            table_class: "table table-responsive table-hover table-sm",
            columns: [
                {
                    label: '№ акту',
                    field: 'number'
                },
                {
                    label: 'Дата акту',
                    field: 'date'
                },
                {
                    label: 'Назва контрагента (скорочена)',
                    field: 'Назва контрагента (скорочена)'
                },
                {
                    label: 'ЄДРПОУ',
                    field: 'edrpou'
                },
                {
                    label: 'Сума з ПДВ',
                    field: 'amount'
                },
                {
                    label: 'Дата протоколу',
                    field: 'protocol_date'
                },
            ],
            acts: [],
            actsForTable: [],
            tableFilter: {
                dates: {
                    startDate: '',
                    endDate: new Date(),
                },
            },
            ranges: {
                'Сьогодні': [today, today],
                'Вчора': [yesterday, yesterday],
                'Минулий місяць': [new Date(today.getFullYear(), today.getMonth() - 1, 1), new Date(today.getFullYear(), today.getMonth(), 0)],
                'Поточний місяць': [new Date(today.getFullYear(), today.getMonth(), 1), new Date(today.getFullYear(), today.getMonth() + 1, 0)],
                'Поточний рік': [new Date(today.getFullYear(), 0, 1), new Date(today.getFullYear(), 11, 31)],
            },
            locale: {
                format: 'yyyy-mm-dd',
                separator: ' - ',
                applyLabel: 'Прийняти',
                cancelLabel: 'Відмінити',
                daysOfWeek: ['НД', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'],
                monthNames: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
                firstDay: 1,
            },
            json_fields: {
                '№ акту': 'number',
                'Дата акту': 'date',
                'Контрагент': 'firm_name_short',
                '№ рахунку': 'number_invoice',
                'Сума з ПДВ, грн.': {
                    field: 'amount',
                    callback: (value) => {
                        return (value != '0.00') ? "=TEXT(" + `${value}` + ",\"#.00\")" : `${value}`;
                    },
                },
                'Дата протоколу': 'protocol_date',
            },
            json_meta: [
                [
                    {
                        key: "charset",
                        value: "utf-8",
                    },
                ],
            ],
            fileName: 'Перелік актів',
        }
    },
    computed: {
        filterForActs: function () {
            return this.tableFilter;
        },
    },
    watch: {
        filterForActs: {
            handler(val) {
                this.actsForTable = this.acts.filter(d => {
                    let time = new Date(d.date).getTime();
                    return (this.tableFilter.dates.startDate < time && time < this.tableFilter.dates.endDate);
                });
            },
            deep: true
        },
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/acts')
            .then(response => {
                this.acts = response.data
                this.tableFilter.dates.startDate = new Date();
                this.tableFilter.dates.startDate.setFullYear(this.tableFilter.dates.startDate.getFullYear() - 1);
                this.actsForTable = this.acts.filter(d => {
                    let time = new Date(d.date).getTime();
                    return (this.tableFilter.dates.startDate < time && time < this.tableFilter.dates.endDate);
                });
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

.download-excel {
    display: inline-block;
}

.slot {
    padding-top: 12px;
    padding-bottom: 7px;
    background-color: #6c757d;
    color: white;
    text-align: center;
}
</style>

<style>
/*см. invoices/Index.vue*/
</style>
