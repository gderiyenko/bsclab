<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Новий акт</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <form @submit.prevent="actCreate">

                    <input type="hidden" class="form-control"
                           v-model="act.firm_id = this.$route.params.firm_id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Номер акту</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_number }"
                                       :placeholder="maxNumberAct"
                                       v-model="act.number">
                                <span class="invalid-feedback" role="alert" v-for="item in error_number">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Дата акту</label>
                                <br>
                                <date-picker
                                    v-bind:class="{ 'is-invalid': error_date }"
                                    v-model="act.date" valueType="format" disabled="disabled">
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
                                <label>Рахунок</label>
                                <select class="custom-select d-block w-100"
                                        v-bind:class="{ 'is-invalid': error_invoice_id }"
                                        v-model="act.invoice_id">
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
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Дата протоколу</label>
                                <br>
                                <date-picker
                                    v-bind:class="{ 'is-invalid': error_protocol_date }"
                                    v-model="act.protocol_date" valueType="format">
                                </date-picker>
                                <span class="invalid-feedback" role="alert" v-for="item in error_protocol_date">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary pull-right">Додати
                        </button>
                        <router-link :to="{ name : 'acts.show', params: { id: this.$route.params.firm_id }}"
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
            act: {},
            acts: {},
            maxNumberAct: '',
            actsNumbers: [],
            invoices: [],
            error_number: '',
            error_date: '',
            error_invoice_id: '',
            error_protocol_date: '',
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/acts')
            .then(response => {
                this.acts = response.data
                if (this.acts.length) {
                    for (let key in this.acts) {
                        if (Number(this.acts[key]['number'])) {
                            this.actsNumbers.push(Number(this.acts[key]['number']))
                        }
                    }
                    if (this.actsNumbers.length) {
                        this.maxNumberAct = this.actsNumbers.reduce(function (a, b) {
                            return Math.max(a, b);
                        });
                        this.act['number'] = ++this.maxNumberAct
                    } else {
                        this.act['number'] = 1;
                    }
                }

                this.getInvoices()
            });
    },
    computed: {
        protocol_date() {
            return this.act.protocol_date;
        }
    },
    watch: {
        protocol_date(newVal, oldVal) {
            // alert(newVal);
            // alert(newVal);
            this.act.date = newVal
        }
    },
    methods: {
        getInvoices() {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/invoices/show/' + `${this.$route.params.firm_id}`)
                .then((response) => {
                    this.invoices = response.data;
                })
                .catch(error => {
                });
        },
        actCreate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/acts/' + `${this.$route.params.firm_id}` + '/create', this.act)
                .then(response => (
                    this.$router.push({name: 'acts.show', params: {id: `${this.$route.params.firm_id}`}})
                ))
                .catch(error => {
                    this.error_number = error.response.data.errors.number
                    this.error_date = error.response.data.errors.date
                    this.error_invoice_id = error.response.data.errors.invoice_id
                    this.error_protocol_date = error.response.data.errors.protocol_date
                })
                .finally(() => this.loading = false)
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
input[type="text"]:disabled {
    color: #495057 !important;
}

.mx-datepicker {
    height: 38px;
    width: 100%;
}

.mx-input {
    height: 38px;
    width: 100%;
}
</style>
