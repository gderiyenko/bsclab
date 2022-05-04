<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-3">
                    <select class="form-control" v-model="tableFilter.paidOrNot">
                        <option value="all">Сплачені та не сплачені</option>
                        <option value="paid">Сплачені</option>
                        <option value="notPaid">Не сплачені</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <h4 class="text-center">Рахунки</h4>
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
                            <h6><b>Інтервал дат рахунків для фільтрації</b></h6>
                        </div>

                    </date-range-picker>

                    <download-excel
                        class="download-excel"
                        :data="invoicesForTable"
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
                :rows="invoicesForTable"
                :row-style-class="rowStyleClassFn"
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
                    label: '№ рахунку',
                    field: 'number'
                },
                {
                    label: 'Дата рахунку',
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
                    label: 'Вид оплати',
                    field: 'payment_type_text'
                },
                {
                    label: 'Сума з ПДВ',
                    field: 'amount'
                },
                {
                    label: 'Сплачено з ПДВ',
                    field: 'amount_pay'
                },
                {
                    label: 'Баланс',
                    field: 'balance'
                },
                {
                    label: 'Дата протоколу',
                    field: 'protocol_date'
                },
            ],
            invoices: [],
            invoicesForTable: [],
            tableFilter: {
                paidOrNot: 'all',
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
                '№ рахунку': 'number',
                'Дата рахунку': 'date',
                'Контрагент': 'firm_name_short',
                'Вид оплати': 'payment_type_text',
                'Сума з ПДВ, грн.': {
                    field: 'amount',
                    callback: (value) => {
                        return (value != '0.00') ? "=TEXT(" + `${value}` + ",\"#.00\")" : `${value}`;
                    },
                },
                'Сплачено з ПДВ, грн.': {
                    field: 'amount_pay',
                    callback: (value) => {
                        return (value != '0.00') ? "=TEXT(" + `${value}` + ",\"#.00\")" : `${value}`;
                    },
                },
                'Баланс, грн.': {
                    field: 'balance',
                    callback: (value) => {
                        return (value != '0.00') ? "=TEXT(" + `${value}` + ",\"#.00\")" : `${value}`;
                    },
                },
                '№ акту': 'act_number',
                'Дата акту': 'act_date',
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
            fileName: 'Перелік рахунків',
        }
    },
    computed: {
        filterForInvoices: function () {
            return this.tableFilter;
        },
    },
    watch: {
        filterForInvoices: {
            handler(val) {
                this.invoicesForTable = this.invoices.filter(d => {
                    let time = new Date(d.date).getTime();
                    return (this.tableFilter.dates.startDate < time && time < this.tableFilter.dates.endDate);
                });

                if (this.tableFilter.paidOrNot == 'paid') {
                    this.invoicesForTable = this.invoicesForTable.filter(function (invoicesForTable) {
                        return (Number(invoicesForTable.amount) <= Number(invoicesForTable.amount_pay)
                            && Number(invoicesForTable.amount_pay) != 0);
                    });
                }

                if (this.tableFilter.paidOrNot == 'notPaid') {
                    this.invoicesForTable = this.invoicesForTable.filter(function (invoicesForTable) {
                        return Number(invoicesForTable.amount) > Number(invoicesForTable.amount_pay);
                    });
                }
            },
            deep: true
        },
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/invoices')
            .then(response => {
                this.invoices = response.data
                this.tableFilter.dates.startDate = new Date();
                this.tableFilter.dates.startDate.setFullYear(this.tableFilter.dates.startDate.getFullYear() - 1);
                this.invoicesForTable = this.invoices.filter(d => {
                    let time = new Date(d.date).getTime();
                    return (this.tableFilter.dates.startDate < time && time < this.tableFilter.dates.endDate);
                });
            });
    },
    methods: {
        rowStyleClassFn(row) {
            if (Number(row.amount) < Number(row.amount_pay)) {
                return 'red'
            }
            if (Number(row.amount) == Number(row.amount_pay)) {
                return 'green'
            }
        }
    }
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
.green {
    background-color: #e6ffe6 !important;
}

.red {
    background-color: #ffcccc !important;
}

.vgt-global-search {
    background: #343a40 !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
}

.vgt-global-search__input .input__icon .magnifying-glass {
    border: 2px solid #f8f9fa;
}

.vgt-global-search__input .input__icon .magnifying-glass:before {
    background: #f8f9fa;
}

.vgt-input, .vgt-select {
    color: #212529;
    background: #fff;
    border: 1px dotted #343a40;
}

table.vgt-table thead th {
    background: #636970 !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #f8f9fa !important;
    text-align: center;
    vertical-align: middle;
}

table.vgt-table thead tr {
    background: #343a40 !important;
}

table.vgt-table th.line-numbers {
    padding: .75em .75em .75em .75em;
    vertical-align: top;
    color: #f8f9fa !important;
    background: #636970;
    font-weight: 400;
    border-collapse: collapse;
}

.vgt-table.bordered td, .vgt-table.bordered th {
    border: 1px dotted #343a40;
}

table.vgt-table td {
    color: #212529;
}

.vgt-wrap__footer {
    color: #212529;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    font-weight: 400;
    line-height: 1.5;
    padding: 1em;
    border: 1px dotted #343a40;
    background: #fff;
}

.vgt-wrap__footer .footer__navigation__info, .vgt-wrap__footer .footer__navigation__page-btn, .vgt-wrap__footer .footer__navigation__page-info {
    color: #212529;
}

.vgt-wrap__footer {
    border: 1px dotted #343a40;
}
</style>
