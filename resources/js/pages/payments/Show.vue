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
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8">
                    <h4 class="text-center">Платежі контрагента</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'payments.create', params: {firm_id: firm_id}}"
                                 class="btn btn-outline-secondary pull-right">
                        Новий
                    </router-link>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead text-left thead-dark">
                <tr>
                    <th>Дата</th>
                    <th>Сума</th>
                    <th>№ рахунку</th>
                    <th>Примітка</th>
                    <th class="text-right pr-5">Дія</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="payments.length">
                    <tr v-for="payment in payments" :key="payment.id">
                        <td>{{ payment.date }}</td>
                        <td>{{ payment.amount }}</td>
                        <td>{{ payment.invoice.number }}</td>
                        <td>{{ payment.description }}</td>
                        <td class="text-right">
                            <fa-layer v-if="$auth.check(['admin', 'accountant'])" class="fa-1x">
                                <router-link :to="{name: 'payments.edit', params: { id: payment.id }}"
                                             :title="'Редагувати'">
                                    <fa-icon :icon="['fa', 'pencil-alt']"
                                             style="color:Grey"/>
                                </router-link>
                            </fa-layer>
                            <span v-if="$auth.check(['admin'])" @click="deletePayment(payment.id)" :title="'Видалити'">
                                <fa-layer class="fa-1x">
                                    <fa-icon :icon="['fa', 'trash']" style="color:Tomato; cursor:pointer;"/>
                                </fa-layer>
                            </span>
                            <span @click="showPaymentLog(payment.id)">
                                <span v-b-modal="payment.id" :title="'Історія'">
                                    <fa-layer class="fa-1x">
                                        <fa-icon :icon="['fa', 'info']" style="color:DodgerBlue; cursor:pointer;"/>
                                    </fa-layer>
                                </span>
                                <b-modal :id="payment.id" size="lg" title="Історія платежу контрагента"
                                         :hide-footer="true">
                                    <template v-for="paymentLog in paymentsLog">
                                        <h6><strong>Дата: {{ paymentLog.created_at.slice(0, 10) }}</strong></h6>
                                        <h6>Дія: {{ paymentLog.action_name }}</h6>
                                        <h6>Користувач: {{ paymentLog.user_name }}</h6>
                                        <h6>Дата платежу: {{ paymentLog.date }}</h6>
                                        <h6>Сума платежу: {{ paymentLog.amount }}</h6>
                                        <h6>№ рахунку: {{ paymentLog.invoice_number }}</h6>
                                        <h6>Примітка: {{ paymentLog.description }}</h6>
                                        <hr>
                                    </template>
                                </b-modal>
                            </span>
                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td align="center" colspan="5"><b>Платежі відсутні</b></td>
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
            payments: [],
            paymentsLog: {},
            firm: {},
            firm_id: '',
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/payments/show/' + `${this.$route.params.id}`)
            .then((response) => {
                this.firm_id = this.$route.params.id
                this.firmShow(this.firm_id)
                this.payments = response.data;
            })
            .catch(error => {
                this.$router.push({name: 'firms'})
            });
    },
    methods: {
        deletePayment(id) {
            if (confirm("Видалити цей платіж?")) {
                this.axios
                    .delete(process.env.MIX_APP_URL + '/api/payments/delete/' + `${id}`)
                    .then(response => {
                        let i = this.payments.map(item => item.id).indexOf(id);
                        this.payments.splice(i, 1)
                        alert('Ви видалили платіж')
                    }).catch(error => {
                });
            }
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
        showPaymentLog(paymentId) {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/paymentsLog/show/' + `${paymentId}`)
                .then((response) => {
                    this.paymentsLog = response.data;
                })
                .catch(error => {
                });
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
</style>
