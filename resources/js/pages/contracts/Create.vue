<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Новий договір</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <form @submit.prevent="contractCreate">

                    <div class="mb-3">

                        <input type="hidden" class="form-control"
                               v-model="contract.firm_id = this.$route.params.firm_id">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Номер договору</label>
                                    <input type="text" class="form-control"
                                           v-bind:class="{ 'is-invalid': error_number }"
                                           :placeholder="maxNumberContract"
                                           v-model="contract.number">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_number">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Дата договору</label>
                                    <br>
                                    <date-picker
                                        v-bind:class="{ 'is-invalid': error_date_contract }"
                                        v-model="contract.date_contract" valueType="format">
                                    </date-picker>
                                    <span class="invalid-feedback" role="alert" v-for="item in error_date_contract">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Дата припинення</label>
                                    <br>
                                    <date-picker
                                        v-bind:class="{ 'is-invalid': error_date_end }"
                                        v-model="contract.date_end" valueType="format">
                                    </date-picker>
                                    <span class="invalid-feedback" role="alert" v-for="item in error_date_end">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Сума</label>
                                    <input type="text" class="form-control"
                                           v-bind:class="{ 'is-invalid': error_amount }"
                                           v-model="contract.amount"
                                           @keypress="priceFormat($event)">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_amount">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Примітка</label>
                                    <input type="text" class="form-control"
                                           v-bind:class="{ 'is-invalid': error_note }"
                                           v-model="contract.note">
                                    <span class="invalid-feedback" role="alert" v-for="item in error_note">
                                        <strong>{{ item }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                           v-model="contract.category">
                                    <label class="form-check-label" for="exampleCheck1">Одноразовий</label>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div>
                            <button type="submit" class="btn btn-outline-secondary pull-right">Додати
                            </button>
                            <router-link :to="{ name : 'contracts.show', params: { id: contract.firm_id }}"
                                         class="btn btn-outline-danger float-right">
                                Відмінити
                            </router-link>
                        </div>
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
            contract: {},
            contracts: {},
            maxNumberContract: '',
            contractsNumbers: [],
            firms: {},
            error_number: '',
            error_date_contract: '',
            error_date_end: '',
            error_amount: '',
            error_note: '',
        }
    },
    computed: {
        date_contract() {
            return this.contract.date_contract;
        }
    },
    watch: {
        date_contract(newVal, oldVal) {
            //alert(newVal);
            //alert(oldVal);
            let datePlusYear = new Date(new Date(newVal).setFullYear(new Date(newVal).getFullYear() + 1))
            this.contract.date_end = datePlusYear.getFullYear() + '-' + ('0' + (datePlusYear.getMonth() + 1)).slice(-2) + '-' + ('0' + datePlusYear.getDate()).slice(-2)
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/contracts')
            .then(response => {
                this.contracts = response.data
                for (let key in this.contracts) {
                    if (Number(this.contracts[key]['number'])) {
                        this.contractsNumbers.push(Number(this.contracts[key]['number']))
                    }
                }
                this.maxNumberContract = this.contractsNumbers.reduce(function (a, b) {
                    return Math.max(a, b);
                });
                this.contract['number'] = ++this.maxNumberContract
            })
            .catch(error => {
                this.contract['number'] = 1
            })
    },
    methods: {
        contractCreate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/contracts/' + `${this.$route.params.firm_id}` + '/create', this.contract)
                .then(response => (
                    this.$router.push({name: 'contracts.show', params: {id: this.contract.firm_id}})
                ))
                .catch(error => {
                    this.error_number = error.response.data.errors.number
                    this.error_date_contract = error.response.data.errors.date_contract
                    this.error_date_end = error.response.data.errors.date_end
                    this.error_amount = error.response.data.errors.amount
                    this.error_note = error.response.data.errors.note
                })
                .finally(() => this.loading = false)
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
