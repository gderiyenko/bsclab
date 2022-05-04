<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Редагування рахунку</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <form @submit.prevent="invoiceUpdate">

                    <div class="mb-3">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Номер рахунку</label>
                                    <input type="text" class="form-control"
                                           v-bind:class="{ 'is-invalid': error_number }"
                                           :placeholder="maxNumberInvoice"
                                           v-model="invoice.number">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_number">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Дата рахунку</label>
                                    <br>
                                    <date-picker
                                        v-bind:class="{ 'is-invalid': error_date }"
                                        v-model="invoice.date" valueType="format">
                                    </date-picker>
                                    <span class="invalid-feedback" role="alert" v-for="item in error_date">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Договір</label>
                                    <select class="custom-select d-block w-100"
                                            v-bind:class="{ 'is-invalid': error_contract_id }"
                                            v-model="invoice.contract_id">
                                        <option v-for="contract in contracts" v-bind:value="contract.id">
                                            № {{ contract.number }} від {{ contract.date_contract }} -
                                            {{ contract.status }}
                                        </option>
                                        <option value=''>Без договору</option>
                                    </select>
                                    <span class="invalid-feedback" role="alert" v-for="item in error_contract_id">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Вид оплати</label>
                                    <select class="custom-select d-block w-100"
                                            v-bind:class="{ 'is-invalid': error_payment_type }"
                                            v-model="invoice.payment_type">
                                        <option v-for="type in paymentTypes" v-bind:value="type.value">
                                            {{ type.text }}
                                        </option>
                                    </select>
                                    <span class="invalid-feedback" role="alert" v-for="item in error_payment_type">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div v-for="(service, index) in this.lines" :key="index" class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Послуга</label>
                                    <select class="custom-select d-block w-100"
                                            v-model="service.service_id">
                                        <optgroup v-for="material in services" v-if="material.parent_id == 0"
                                                  :label="material.name">
                                            <option v-for="property in services"
                                                    v-if="material.id == property.parent_id"
                                                    v-bind:value="property.id">
                                                {{ property.name }}
                                            </option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label>Кількість</label>
                                    <input type="number" class="form-control"
                                           v-model="service.service_quantity">
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label>Ціна з ПДВ</label>
                                    <input type="text" class="form-control"
                                           v-model="service.service_price"
                                           @keypress="priceFormat($event)">
                                </div>
                            </div>
                            <div class="col-md-2 mb-3 text-right">
                                <div class="form-group center">
                                    <br><br>
                                    <span @click="removeLine(index)" :title="'Видалити'">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fa', 'trash']" style="color:Grey; cursor:pointer;"/>
                                        </fa-layer>
                                    </span>
                                    <span v-if="index + 1 === lines.length" @click="addLine" :title="'Додати'">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'plus']" style="color:Grey; cursor:pointer;"/>
                                        </fa-layer>
                                    </span>

                                </div>
                            </div>
                        </div>

                        <span class="err" v-for="item in error_service_id">
                            <strong>{{ item }}</strong>
                        </span>
                        <span class="err" v-for="item in error_quantity">
                            <strong>{{ item }}</strong>
                        </span>
                        <span class="err" v-for="item in error_price">
                            <strong>{{ item }}</strong>
                        </span>

                        <hr>
                        <h6><strong>Всього по рахунку</strong></h6>
                        <br>
                        <label>Сума з ПДВ</label>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" readonly
                                           v-bind:class="{ 'is-invalid': error_amount }"
                                           v-model="Number(invoice.amount).toFixed(2)">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_amount">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                           v-bind:class="{ 'is-invalid': error_amount_text }"
                                           v-model="invoice.amount_text">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_amount_text">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <label>У тому числі ПДВ</label>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" readonly
                                           v-bind:class="{ 'is-invalid': error_pdv }"
                                           v-model="Number(invoice.pdv).toFixed(2)">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_pdv">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                           v-bind:class="{ 'is-invalid': error_pdv_text }"
                                           v-model="invoice.pdv_text">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_pdv_text">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <label>Загальна вартість без ПДВ</label>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" readonly
                                           v-bind:class="{ 'is-invalid': error_pdv_minus }"
                                           v-model="Number(invoice.pdv_minus).toFixed(2)">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_pdv_minus">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                           v-bind:class="{ 'is-invalid': error_pdv_minus_text }"
                                           v-model="invoice.pdv_minus_text">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_pdv_minus_text">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <br>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary pull-right">Прийняти зміни
                        </button>
                        <router-link :to="{ name : 'invoices.show', params: { id: invoice.firm_id }}"
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
import {numberToWordsConverter} from './../../converter.js';

export default {
    name: "Edit",
    components: {
        DatePicker
    },
    data() {
        return {
            invoice: {},
            invoices: {},
            contracts: [],
            services: [],
            service: [],
            maxNumberInvoice: '',
            invoicesNumbers: [],
            lines: [],
            blockRemoval: true,
            error_number: '',
            error_date: '',
            error_contract_id: '',
            error_service_id: '',
            error_payment_type: '',
            error_quantity: '',
            error_price: '',
            error_amount: '',
            error_amount_text: '',
            error_pdv: '',
            error_pdv_text: '',
            error_pdv_minus: '',
            error_pdv_minus_text: '',
            paymentTypes: [
                {text: '100% попередня оплата', value: 'all'},
                {text: 'часткова попередня оплата', value: 'partial'},
            ],
        }
    },
    computed: {
        amountInText: function () {
            return this.lines;
        },
    },
    watch: {
        amountInText: {
            handler(val) {
                this.invoice.amount = 0
                for (const key in val) {
                    this.invoice.amount += val[key].service_quantity * val[key].service_price
                    this.invoice.amount_text = numberToWordsConverter.convert(this.invoice.amount)
                }
                this.invoice.pdv = this.invoice.amount / 6
                this.invoice.pdv_text = numberToWordsConverter.convert(this.invoice.pdv)
                this.invoice.pdv_minus = this.invoice.amount * 5 / 6
                this.invoice.pdv_minus_text = numberToWordsConverter.convert(this.invoice.pdv_minus)
            },
            deep: true
        },
        lines() {
            this.blockRemoval = this.lines.length <= 1
        },
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/invoices/edit/' + `${this.$route.params.id}`)
            .then((response) => {
                this.invoice = response.data;
                this.putServicesIntoLines(this.invoice.services)
                this.getContracts()
                this.getServices()
            })
            .catch(error => {
                this.$router.push({name: 'firms'})
            });
    },
    methods: {
        invoiceUpdate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/invoices/update/' + `${this.$route.params.id}`, {
                    invoice: this.invoice,
                    invoiceServices: this.lines
                })
                .then((response) => {
                    this.$router.push({name: 'invoices.show', params: {id: this.invoice.firm_id}})
                })
                .catch(error => {
                    this.error_number = error.response.data.errors['invoice.number']
                    this.error_date = error.response.data.errors['invoice.date']
                    this.error_contract_id = error.response.data.errors['invoice.contract_id']
                    this.error_payment_type = error.response.data.errors['invoice.payment_type']
                    this.error_amount = error.response.data.errors['invoice.amount']
                    this.error_amount_text = error.response.data.errors['invoice.amount_text']
                    this.error_pdv = error.response.data.errors['invoice.pdv']
                    this.error_pdv_text = error.response.data.errors['invoice.pdv_text']

                    this.error_service_id = ''
                    this.error_quantity = ''
                    this.error_price = ''
                    this.error_pdv_minus = error.response.data.errors['invoice.pdv_minus']
                    this.error_pdv_minus_text = error.response.data.errors['invoice.pdv_minus_text']
                    let errorsNumbers = Object.keys(error.response.data.errors).length
                    for (let i = 0; i < errorsNumbers; i++) {

                        let error_service_id = 'invoiceServices.' + i + '.service_id'
                        if (error.response.data.errors[error_service_id]) {
                            this.error_service_id = error.response.data.errors[error_service_id]
                        }

                        let error_quantity = 'invoiceServices.' + i + '.service_quantity'
                        if (error.response.data.errors[error_quantity]) {
                            this.error_quantity = error.response.data.errors[error_quantity]
                        }

                        let error_price = 'invoiceServices.' + i + '.service_price'
                        if (error.response.data.errors[error_price]) {
                            this.error_price = error.response.data.errors[error_price]
                        }
                    }
                })
                .finally(() => this.loading = false)
        },
        priceFormat: function (event) {
            let oldVal = event.target.value;
            event.target.value = oldVal.replace(',', '.').replace(' ', '');
        },
        getContracts() {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/contracts/show/' + `${this.invoice.firm_id}`)
                .then((response) => {
                    this.contracts = response.data;
                    let now = new Date();
                    for (let key in this.contracts) {
                        let date_end = new Date(this.contracts[key]['date_end'])
                        this.contracts[key]['status'] = (date_end >= now) ? 'Діючий' : 'Не діючий'
                    }
                })
                .catch(error => {
                });
        },
        getServices() {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/services')
                .then((response) => {
                    this.services = response.data;
                })
                .catch(error => {
                });
        },
        addLine() {
            let checkEmptyLines = this.lines.filter(line => line.number === null)
            if (checkEmptyLines.length >= 1 && this.lines.length > 0) {
                return
            }
            this.lines.push({
                service_id: null,
                service_quantity: null,
                service_price: null
            })
        },
        removeLine(lineId) {
            if (!this.blockRemoval) {
                this.lines.splice(lineId, 1)
            }
        },
        putServicesIntoLines(servicesList) {
            servicesList.forEach(service => this.lines.push({
                invoice_id: service.invoice_id,
                service_id: service.service_id,
                service_quantity: service.service_quantity,
                service_price: service.service_price
            }));
        }
    },
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

.fa-1x {
    margin-right: 20px;
}

.err {
    font-size: 85%;
    color: #dc3545;
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
