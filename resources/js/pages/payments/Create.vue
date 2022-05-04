<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Новий платіж</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <form @submit.prevent="paymentCreate">

                    <input type="hidden" class="form-control"
                           v-model="payment.firm_id = this.$route.params.firm_id">

                    <div class="mb-3">
                        <div class="form-group">
                            <label>Дата</label>
                            <br>
                            <date-picker
                                v-bind:class="{ 'is-invalid': error_date }"
                                placeholder="Введіть дату"
                                v-model="payment.date" valueType="format">
                            </date-picker>
                            <span class="invalid-feedback" role="alert" v-for="item in error_date">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Сума</label>
                            <input type="text" class="form-control"
                                   v-bind:class="{ 'is-invalid': error_amount }"
                                   placeholder="Вкажіть суму"
                                   v-model="payment.amount"
                                   @keypress="priceFormat($event)">
                            <span class="invalid-feedback" role="alert" v-for="item in error_amount">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Згідно рахунку</label>
                            <select class="custom-select d-block w-100"
                                    v-bind:class="{ 'is-invalid': error_invoice_id }"
                                    v-model="payment.invoice_id">
                                <option v-for="invoice in invoices" v-bind:value="invoice.id">
                                    № {{ invoice.number }} від {{ invoice.date }} -
                                    {{ invoice.amount }} грн.
                                </option>
                            </select>
                            <span class="invalid-feedback" role="alert" v-for="item in error_invoice_id">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Примітка</label>
                            <input type="text" class="form-control"
                                   v-bind:class="{ 'is-invalid': error_description }"
                                   v-model="payment.description">
                            <span class="invalid-feedback" role="alert" v-for="item in error_description">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>

                    <br>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary pull-right">Додати
                        </button>
                        <router-link :to="{ name : 'payments.show', params: { id: payment.firm_id }}"
                                     class="btn btn-outline-danger float-right">
                            Відмінити
                        </router-link>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/uk';

export default {
    name: "Create",
    components: {
        DatePicker
    },
    data() {
        return {
            payment: {},
            invoices: [],
            error_date: '',
            error_amount: '',
            error_invoice_id: '',
            error_description: '',
        }
    },
    created() {
        this.getInvoices()
    },
    methods: {
        paymentCreate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/payments/' + `${this.$route.params.firm_id}` + '/create', this.payment)
                .then(response => (
                    this.$router.push({name: 'payments.show', params: {id: this.payment.firm_id}})
                ))
                .catch(error => {
                    this.error_date = error.response.data.errors.date
                    this.error_amount = error.response.data.errors.amount
                    this.error_invoice_id = error.response.data.errors.invoice_id
                    this.error_description = error.response.data.errors.description
                })
                .finally(() => this.loading = false)
        },
        getInvoices() {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/invoices/show/' + `${this.$route.params.firm_id}`)
                .then((response) => {
                    this.invoices = response.data;
                })
                .catch(error => {
                });
        },
        priceFormat: function (event) {
            let oldVal = event.target.value;
            event.target.value = oldVal.replace(',', '.').replace(' ', '');
        },
    }
}
</script>

<style scoped>
.container {
    margin-bottom: 100px;
}

.py-5 {
    padding: 120px 0px 0px 0px !important;
    margin-bottom: 30px;
}
</style>

<style>
.mx-datepicker {
    height: 38px;
    width: 100%;
}

.mx-input {
    height: 38px;
    width: 100%;
}
</style>
