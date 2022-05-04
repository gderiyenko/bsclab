<template>
    <div class="container-2xl">

        <div class="row">
            <FirmsMenu :firm_id="firm_id"></FirmsMenu>
            <div class="col-sm-5 text-info text-right">
                <h6><strong>{{ firm.firm_name }}</strong></h6>
            </div>
        </div>

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <h4 class="text-center">Рахунки контрагента</h4>
                </div>
                <div class="col-sm-3 text-right">
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'invoices.create', params: {firm_id: firm_id}}"
                                 class="btn btn-outline-secondary pull-right">
                        Новий
                    </router-link>
                    <download-excel
                        class="download-excel"
                        :data="invoices"
                        :fields="json_fields"
                        :type="'xls'"
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

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead text-left thead-dark">
                <tr>
                    <th>№ рахунку</th>
                    <th>Дата рахунку</th>
                    <th>Сума з ПДВ</th>
                    <th>Сплачено з ПДВ</th>
                    <th>Баланс</th>
                    <th>№ договору</th>
                    <th>Послуги</th>
                    <th class="text-right pr-5">Дія</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="invoices.length">
                    <tr v-for="invoice in invoices" :key="invoice.id" v-bind:style="{ background: invoice.color }">
                        <td>{{ invoice.number }}</td>
                        <td>{{ invoice.date }}</td>
                        <td>{{ invoice.amount }}</td>
                        <td>{{ invoice.amount_pay }}</td>
                        <td>{{ invoice.balance }}</td>
                        <td>{{ invoice.contract_number }}</td>
                        <td>{{ invoice.number_services }}</td>
                        <td class="text-right">

                            <fa-layer v-if="$auth.check(['admin', 'accountant'])" class="fa-1x">
                                <router-link :to="{name: 'invoices.edit', params: { id: invoice.id }}"
                                             :title="'Редагувати'">
                                    <fa-icon :icon="['fa', 'pencil-alt']"
                                             style="color:Grey"/>
                                </router-link>
                            </fa-layer>

                            <span v-if="$auth.check(['admin'])" @click="deleteInvoice(invoice.id)" :title="'Видалити'">
                                <fa-layer class="fa-1x">
                                    <fa-icon :icon="['fa', 'trash']" style="color:Tomato; cursor:pointer;"/>
                                </fa-layer>
                            </span>

                            <span @click="showTemplates(type)">
                                <span v-b-modal="invoice.number" :title="'Завантажити'">
                                    <fa-layer class="fa-1x">
                                        <fa-icon :icon="['fa', 'download']" style="color:grey; cursor:pointer;"/>
                                    </fa-layer>
                                </span>
                                <b-modal :id="invoice.number" size="lg" title="Виберіть рахунок для завантаження"
                                         :hide-footer="true">
                                    <table class="table table-hover w-100 d-block d-md-table table-borderless">
                                        <tbody>
                                            <tr v-for="template in templates"
                                                @click="docxCreate(invoice.id, template)"
                                                style="cursor:pointer;">
                                                <td>
                                                    {{ template.name }}
                                                </td>
                                                <td class="text-right">
                                                    <fa-layer class="fa-1x">
                                                        <fa-icon :icon="['fa', 'download']"
                                                                 style="color:grey; cursor:pointer;"/>
                                                    </fa-layer>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </b-modal>
                            </span>

                            <span @click="showInvoiceLog(invoice.id)">
                                <span v-b-modal="invoice.id" :title="'Історія'">
                                    <fa-layer class="fa-1x">
                                        <fa-icon :icon="['fa', 'info']" style="color:DodgerBlue; cursor:pointer;"/>
                                    </fa-layer>
                                </span>
                                <b-modal :id="invoice.id" size="lg"
                                         title="Історія рахунку контрагента"
                                         :hide-footer="true">
                                    <template v-for="invoiceLog in invoicesLog">
                                        <h6><strong>Дата: {{
                                                invoiceLog.created_at.slice(0, 10)
                                            }}</strong></h6>
                                        <h6>Дія: {{ invoiceLog.action_name }}</h6>
                                        <h6>Користувач: {{ invoiceLog.user_name }}</h6>
                                        <h6>№ рахунку: {{
                                                invoiceLog.invoice_number
                                            }}</h6>
                                        <h6>Дата рахунку: {{ invoiceLog.invoice_date }}</h6>
                                        <h6>№ договору: {{
                                                invoiceLog.contract_number
                                            }}</h6>
                                        <h6>Вид оплати: {{
                                                convertType(invoiceLog.payment_type)
                                            }}</h6>
                                        <h6>Cума з ПДВ: {{ invoiceLog.amount }}</h6>
                                        <hr>
                                    </template>
                                </b-modal>
                            </span>

                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td align="center" colspan="8"><b>Рахунки відсутні</b></td>
                    </tr>
                </template>

                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
import FirmsMenu from '../../components/FirmsMenu';

export default {
    name: "Show",
    components: {
        FirmsMenu,
    },
    data() {
        return {
            invoices: [],
            invoicesLog: {},
            type: 'invoice',
            templates: {},
            firm: {},
            firm_id: '',
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
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/invoices/show/' + `${this.$route.params.id}`)
            .then((response) => {
                this.firm_id = this.$route.params.id
                this.firmShow(this.firm_id)
                this.invoices = response.data;
                for (let key in this.invoices) {
                    if (Number(this.invoices[key]['amount']) < Number(this.invoices[key]['amount_pay'])) {
                        this.invoices[key]['color'] = '#ffcccc'
                    }
                    if (Number(this.invoices[key]['amount']) == Number(this.invoices[key]['amount_pay'])) {
                        this.invoices[key]['color'] = '#e6ffe6'
                    }
                }
            })
            .catch(error => {
                this.$router.push({name: 'firms'})
            });
    },
    methods: {
        deleteInvoice(id) {
            if (confirm("Видалити цей рахунок?")) {
                this.axios
                    .delete(process.env.MIX_APP_URL + '/api/invoices/delete/' + `${id}`)
                    .then(response => {
                        let i = this.invoices.map(item => item.id).indexOf(id);
                        this.invoices.splice(i, 1)
                        alert('Ви видалили рахунок')
                    }).catch(error => {
                });
            }
        },
        docxCreate(invoiceId, template) {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/templates/docx-create', [invoiceId, template])
                .then((response) => {
                    let filename = response.data.fileName;
                    let url = 'data:application/octet-stream;base64,' + response.data.fileBody;
                    let link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', filename);
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                })
                .catch(error => {
                    alert('Помилка!')
                });
        },
        firmShow(id) {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/firms/show/' + `${id}`)
                .then((response) => {
                    this.firm = response.data;
                })
                .catch(error => {
                    this.$router.push({name: 'firms'})
                });
        },
        showTemplates(type) {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/templates/show/' + `${type}`)
                .then((response) => {
                    this.templates = response.data;
                })
                .catch(error => {
                });
        },
        showInvoiceLog(invoiceId) {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/invoicesLog/show/' + `${invoiceId}`)
                .then((response) => {
                    this.invoicesLog = response.data;
                })
                .catch(error => {
                });
        },
        convertType(paymentType) {
            switch (paymentType) {
                case 'all':
                    return '100% попередня оплата';
                case 'partial':
                    return 'часткова попередня оплата';
            }
        },
    }
}
</script>

<style scoped>
.container-2xl {
    margin: 100px 50px;
}

.py-3 {
    margin-top: 20px;
}

.fa-1x {
    margin-right: 20px;
}

table {
    width: 100%;
    word-break: break-word;
}

.download-excel {
    display: inline-block;
}

.download-excel .fa-1x {
    margin-right: 0px;
}
</style>
