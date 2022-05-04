<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Новий контрагент</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="firmCreate">

                    <h4 class="mb-3">Назва контрагента</h4>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label>Повна назва</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_firm_name }"
                                       v-model="firm.firm_name">
                                <span class="invalid-feedback" role="alert" v-for="item in error_firm_name">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>Скорочена назва</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_firm_name_short }"
                                       v-model="firm.firm_name_short">
                                <span class="invalid-feedback" role="alert" v-for="item in error_firm_name_short">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>Код ЄДРПОУ</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_edrpou }"
                                       v-model="firm.edrpou">
                                <span class="invalid-feedback" role="alert" v-for="item in error_edrpou">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>ІПН</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_ipn }"
                                       v-model="firm.ipn">
                                <span class="invalid-feedback" role="alert" v-for="item in error_ipn">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Оподаткування</label>
                                <select class="form-control"
                                        v-bind:class="{ 'is-invalid': error_tax }"
                                        v-model="firm.tax">
                                    <option v-for="tax in taxes" v-bind:value="tax">
                                        {{ tax }}
                                    </option>
                                </select>
                                <span class="invalid-feedback" role="alert" v-for="item in error_tax">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Керівництво</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Посада керівника</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_boss_position }"
                                       v-model="firm.boss_position">
                                <span class="invalid-feedback" role="alert" v-for="item in error_boss_position">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>ПІБ керівника</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_boss_pib }"
                                       v-model="firm.boss_pib">
                                <span class="invalid-feedback" role="alert" v-for="item in error_boss_pib">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Посада відповідального за роботи</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_work_position }"
                                       v-model="firm.work_position">
                                <span class="invalid-feedback" role="alert" v-for="item in error_work_position">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>ПІБ відповідального за роботи</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_work_pib }"
                                       v-model="firm.work_pib">
                                <span class="invalid-feedback" role="alert" v-for="item in error_work_pib">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Юридична адреса</h4>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label>Індекс</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_zip_ur }"
                                       v-model="firm.addr_zip_ur">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_zip_ur">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>Область</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_obl_ur }"
                                       v-model="firm.addr_obl_ur">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_obl_ur">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Місто (селище, село)</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_city_ur }"
                                       v-model="firm.addr_city_ur">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_city_ur">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Вулиця</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_street_ur }"
                                       v-model="firm.addr_street_ur">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_street_ur">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>Будинок</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_house_ur }"
                                       v-model="firm.addr_house_ur">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_house_ur">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>Офіс (приміщення)</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_office_ur }"
                                       v-model="firm.addr_office_ur">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_office_ur">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Фактична адреса
                        <button type="button" class="btn btn-outline-secondary btn-sm" @click="duplicateAddress()">Вставити з юридичної адреси</button>
                    </h4>
                    <div v-if="showAlert" class="alert alert-info" role="alert">
                        Заповнено з юридичної адреси
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label>Індекс</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_zip_fact }"
                                       v-model="firm.addr_zip_fact">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_zip_fact">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>Область</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_obl_fact }"
                                       v-model="firm.addr_obl_fact">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_obl_fact">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Місто (селище, село)</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_city_fact }"
                                       v-model="firm.addr_city_fact">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_city_fact">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Вулиця</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_street_fact }"
                                       v-model="firm.addr_street_fact">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_street_fact">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>Будинок</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_house_fact }"
                                       v-model="firm.addr_house_fact">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_house_fact">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label>Офіс (приміщення)</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_addr_office_fact }"
                                       v-model="firm.addr_office_fact">
                                <span class="invalid-feedback" role="alert" v-for="item in error_addr_office_fact">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Реквізити банківського рахунку</h4>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label>Назва банку</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_bank_name }"
                                       v-model="firm.bank_name">
                                <span class="invalid-feedback" role="alert" v-for="item in error_bank_name">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="form-group">
                                <label>Номер рахунку</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_account_number }"
                                       v-model="firm.account_number">
                                <span class="invalid-feedback" role="alert" v-for="item in error_account_number">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label>МФО банку</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_bank_mfo }"
                                       v-model="firm.bank_mfo">
                                <span class="invalid-feedback" role="alert" v-for="item in error_bank_mfo">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Контактні дані</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Телефон загальний</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_phone_shared }"
                                       v-model="firm.phone_shared">
                                <span class="invalid-feedback" role="alert" v-for="item in error_phone_shared">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Email загальний</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_email_shared }"
                                       v-model="firm.email_shared">
                                <span class="invalid-feedback" role="alert" v-for="item in error_email_shared">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Телефон бухгалтера</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_phone_acc }"
                                       v-model="firm.phone_acc">
                                <span class="invalid-feedback" role="alert" v-for="item in error_phone_acc">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Email бухгалтера</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_email_acc }"
                                       v-model="firm.email_acc">
                                <span class="invalid-feedback" role="alert" v-for="item in error_email_acc">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Телефон відповідального за роботи</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_phone_work }"
                                       v-model="firm.phone_work">
                                <span class="invalid-feedback" role="alert" v-for="item in error_phone_work">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Email відповідального за роботи</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_email_work }"
                                       v-model="firm.email_work">
                                <span class="invalid-feedback" role="alert" v-for="item in error_email_work">
                                <strong>{{ item }}</strong>
                            </span>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Перевізник</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Назва</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_carr_name }"
                                       v-model="firm.carr_name">
                                <span class="invalid-feedback" role="alert" v-for="item in error_carr_name">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Місто</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_carr_city }"
                                       v-model="firm.carr_city">
                                <span class="invalid-feedback" role="alert" v-for="item in error_carr_city">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Відділення</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_carr_dep }"
                                       v-model="firm.carr_dep">
                                <span class="invalid-feedback" role="alert" v-for="item in error_carr_dep">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>ПІБ отримувача</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_carr_pib }"
                                       v-model="firm.carr_pib">
                                <span class="invalid-feedback" role="alert" v-for="item in error_carr_pib">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label>Телефон отримувача</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_carr_phone }"
                                       v-model="firm.carr_phone">
                                <span class="invalid-feedback" role="alert" v-for="item in error_carr_phone">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Примітка</h4>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label>Примітка</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_note }"
                                       v-model="firm.note">
                                <span class="invalid-feedback" role="alert" v-for="item in error_note">
                                    <strong>{{ item }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary pull-right">Додати
                        </button>
                        <router-link :to="{ name : 'firms' }"
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
export default {
    data() {
        return {
            firm: {},
            firm_id: '',
            taxes: [
                'платник  податку на прибуток на  загальних  підставах',
                'платник єдиного податку з ПДВ',
                'платник єдиного податку без ПДВ'
            ],
            showAlert: false,
            error_firm_name: '',
            error_firm_name_short: '',
            error_boss_position: '',
            error_boss_pib: '',
            error_work_position: '',
            error_work_pib: '',
            error_addr_zip_ur: '',
            error_addr_obl_ur: '',
            error_addr_city_ur: '',
            error_addr_street_ur: '',
            error_addr_house_ur: '',
            error_addr_office_ur: '',
            error_addr_zip_fact: '',
            error_addr_obl_fact: '',
            error_addr_city_fact: '',
            error_addr_street_fact: '',
            error_addr_house_fact: '',
            error_addr_office_fact: '',
            error_edrpou: '',
            error_ipn: '',
            error_tax: '',
            error_account_number: '',
            error_bank_name: '',
            error_bank_mfo: '',
            error_phone_shared: '',
            error_email_shared: '',
            error_phone_acc: '',
            error_email_acc: '',
            error_phone_work: '',
            error_email_work: '',
            error_carr_name: '',
            error_carr_city: '',
            error_carr_dep: '',
            error_carr_pib: '',
            error_carr_phone: '',
            error_note: '',
        }
    },
    methods: {
        duplicateAddress() {
            this.showAlert = !this.showAlert
            this.firm.addr_zip_fact = this.firm.addr_zip_ur,
                this.firm.addr_obl_fact = this.firm.addr_obl_ur,
                this.firm.addr_city_fact = this.firm.addr_city_ur,
                this.firm.addr_street_fact = this.firm.addr_street_ur,
                this.firm.addr_house_fact = this.firm.addr_house_ur,
                this.firm.addr_office_fact = this.firm.addr_office_ur,
                setTimeout(() => {
                    this.showAlert = !this.showAlert;
                }, 2000);
        },
        firmCreate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/firms/create', this.firm)
                .then((response) => {
                    this.firm_id = response.data.id
                    alert('Ви додали нового контрагента')
                    this.$router.push({name: 'firms.show', params: {id: this.firm_id}})
                })
                .catch(error => {
                    this.error_firm_name = error.response.data.errors.firm_name
                    this.error_firm_name_short = error.response.data.errors.firm_name_short
                    this.error_boss_position = error.response.data.errors.boss_position
                    this.error_boss_pib = error.response.data.errors.boss_pib
                    this.error_work_position = error.response.data.errors.work_position
                    this.error_work_pib = error.response.data.errors.work_pib
                    this.error_addr_zip_ur = error.response.data.errors.addr_zip_ur
                    this.error_addr_obl_ur = error.response.data.errors.addr_obl_ur
                    this.error_addr_city_ur = error.response.data.errors.addr_city_ur
                    this.error_addr_street_ur = error.response.data.errors.addr_street_ur
                    this.error_addr_house_ur = error.response.data.errors.addr_house_ur
                    this.error_addr_office_ur = error.response.data.errors.addr_office_ur
                    this.error_addr_zip_fact = error.response.data.errors.addr_zip_fact
                    this.error_addr_obl_fact = error.response.data.errors.addr_obl_fact
                    this.error_addr_city_fact = error.response.data.errors.addr_city_fact
                    this.error_addr_street_fact = error.response.data.errors.addr_street_fact
                    this.error_addr_house_fact = error.response.data.errors.addr_house_fact
                    this.error_addr_office_fact = error.response.data.errors.addr_office_fact
                    this.error_edrpou = error.response.data.errors.edrpou
                    this.error_ipn = error.response.data.errors.ipn
                    this.error_tax = error.response.data.errors.tax
                    this.error_account_number = error.response.data.errors.account_number
                    this.error_bank_name = error.response.data.errors.bank_name
                    this.error_bank_mfo = error.response.data.errors.bank_mfo
                    this.error_phone_shared = error.response.data.errors.phone_shared
                    this.error_email_shared = error.response.data.errors.email_shared
                    this.error_phone_acc = error.response.data.errors.phone_acc
                    this.error_email_acc = error.response.data.errors.email_acc
                    this.error_phone_work = error.response.data.errors.phone_work
                    this.error_email_work = error.response.data.errors.email_work
                    this.error_carr_name = error.response.data.errors.carr_name
                    this.error_carr_city = error.response.data.errors.carr_city
                    this.error_carr_dep = error.response.data.errors.carr_dep
                    this.error_carr_pib = error.response.data.errors.carr_pib
                    this.error_carr_phone = error.response.data.errors.carr_phone
                    this.error_note = error.response.data.errors.note
                })
                .finally(() => this.loading = false)
        }
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
