<template>
    <div class="container-2xl">

        <div class="row">
            <FirmsMenu :firm_id="firm.id"></FirmsMenu>
            <div class="col-sm-5 text-info text-right">
                <h6><strong>{{ firm.firm_name }}</strong></h6>
            </div>
        </div>

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8">
                    <h4 class="text-center">Інформація про контрагента</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'firms.edit', params: { id: firm.id }}"
                                 class="btn btn-outline-secondary pull-right">
                        Змінити
                    </router-link>
                    <b-button type="button" v-b-modal="firm.id" variant="btn btn-outline-secondary pull-right"
                              @click="showFirmLog(firm.id)">
                        Історія
                    </b-button>
                    <b-modal :id="firm.id" size="lg" title="Історія контрагента"
                             :hide-footer="true">
                        <template v-for="firmLog in firmsLog">
                            <h6><strong>Дата: {{ firmLog.created_at.slice(0, 10) }}</strong></h6>
                            <h6>Дія: {{ firmLog.action_name }}</h6>
                            <h6>Користувач: {{ firmLog.user_name }}</h6>
                            <h6><strong>Загальна інформація</strong></h6>
                            <h6>Назва: {{ firmLog.firm_name }}</h6>
                            <h6>Назва коротка: {{ firmLog.firm_name_short }}</h6>
                            <h6>Керівник: {{ allInOne(firmLog.boss_position, firmLog.boss_pib) }}</h6>
                            <h6>Відповідальний за роботи: {{ allInOne(firmLog.work_position, firmLog.work_pib) }}</h6>
                            <h6>Юридична адреса: {{
                                    allInOne(firmLog.addr_zip_ur, firmLog.addr_obl_ur, firmLog.addr_city_ur, firmLog.addr_street_ur, firmLog.addr_house_ur, firmLog.addr_office_ur)
                                }}</h6>
                            <h6>Фактична адреса: {{
                                    allInOne(firmLog.addr_zip_fact, firmLog.addr_obl_fact, firmLog.addr_city_fact, firmLog.addr_street_fact, firmLog.addr_house_fact, firmLog.addr_office_fact)
                                }}</h6>
                            <h6>Код ЄДРПОУ: {{ firmLog.edrpou }}</h6>
                            <h6>ІПН: {{ firmLog.ipn }}</h6>
                            <h6>Оподаткування: {{ firmLog.tax }}</h6>
                            <h6><strong>Реквізити банківського рахунку</strong></h6>
                            <h6>Номер рахунку: {{ firmLog.account_number }}</h6>
                            <h6>Назва банку: {{ firmLog.bank_name }}</h6>
                            <h6>МФО банку: {{ firmLog.bank_mfo }}</h6>
                            <h6><strong>Контактні дані</strong></h6>
                            <h6>Загальні: {{ allInOne(firmLog.phone_shared, firmLog.email_shared) }}</h6>
                            <h6>Бухгалтер: {{ allInOne(firmLog.phone_acc, firmLog.email_acc) }}</h6>
                            <h6>Відповідальний за роботи: {{ allInOne(firmLog.phone_work, firmLog.email_work) }}</h6>
                            <h6><strong>Перевізник</strong></h6>
                            <h6>Компанія: {{ firmLog.carr_name }}</h6>
                            <h6>Адреса доставки: {{ allInOne(firmLog.carr_city, firmLog.carr_dep) }}</h6>
                            <h6>Отримувач: {{ allInOne(firmLog.carr_pib, firmLog.carr_phone) }}</h6>
                            <h6><strong>Примітка</strong></h6>
                            <h6>Примітка: {{ firmLog.note }}</h6>
                            <hr>
                        </template>
                    </b-modal>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td colspan="2" class="text-center text-light bg-dark">Загальна інформація</td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-right">Назва</td>
                    <td><b>{{ firm.firm_name }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Назва коротка</td>
                    <td><b>{{ firm.firm_name_short }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Керівник</td>
                    <td><b>{{ allInOne(firm.boss_position, firm.boss_pib) }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Відповідальний за роботи</td>
                    <td><b>{{ allInOne(firm.work_position, firm.work_pib) }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Юридична адреса</td>
                    <td><b>{{
                            allInOne(firm.addr_zip_ur, firm.addr_obl_ur, firm.addr_city_ur, firm.addr_street_ur, firm.addr_house_ur, firm.addr_office_ur)
                        }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Фактична адреса</td>
                    <td><b>{{
                            allInOne(firm.addr_zip_fact, firm.addr_obl_fact, firm.addr_city_fact, firm.addr_street_fact, firm.addr_house_fact, firm.addr_office_fact)
                        }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Код ЄДРПОУ</td>
                    <td><b>{{ firm.edrpou }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">ІПН</td>
                    <td><b>{{ firm.ipn }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Оподаткування</td>
                    <td><b>{{ firm.tax }}</b></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center text-light bg-dark">Реквізити банківського рахунку</td>
                </tr>
                <tr>
                    <td class="text-right">Номер рахунку</td>
                    <td><b>{{ firm.account_number }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Назва банку</td>
                    <td><b>{{ firm.bank_name }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">МФО банку</td>
                    <td><b>{{ firm.bank_mfo }}</b></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center text-light bg-dark">Контактні дані</td>
                </tr>
                <tr>
                    <td class="text-right">Загальні</td>
                    <td><b>{{ allInOne(firm.phone_shared, firm.email_shared) }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Бухгалтер</td>
                    <td><b>{{ allInOne(firm.phone_acc, firm.email_acc) }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Відповідальний за роботи</td>
                    <td><b>{{ allInOne(firm.phone_work, firm.email_work) }}</b></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center text-light bg-dark">Перевізник</td>
                </tr>
                <tr>
                    <td class="text-right">Компанія</td>
                    <td><b>{{ firm.carr_name }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Адреса доставки</td>
                    <td><b>{{ allInOne(firm.carr_city, firm.carr_dep) }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Отримувач</td>
                    <td><b>{{ allInOne(firm.carr_pib, firm.carr_phone) }}</b></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center text-light bg-dark">Примітка</td>
                </tr>
                <tr>
                    <td class="text-right">Примітка</td>
                    <td><b>{{ firm.note }}</b></td>
                </tr>
                </tbody>
            </table>
        </div>

        <br>
        <div v-if="$auth.check(['admin'])">
            <button type="submit" class="btn btn-outline-danger float-right" @click="deleteFirm(firm.id)">Видалити
            </button>
        </div>

    </div>
</template>

<script>
import FirmsMenu from "../../components/FirmsMenu";

export default {
    data() {
        return {
            firm: {},
            firmsLog: {},
        }
    },
    components: {
        FirmsMenu,
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/firms/show/' + `${this.$route.params.id}`)
            .then((response) => {
                this.firm = response.data;
            })
            .catch(error => {
                this.$router.push({name: 'firms'})
            });
    },
    methods: {
        allInOne(...theArgs) {
            return theArgs.reduce((previous, current) => {
                this.separator = (!previous || !current) ? '' : ', '
                if (!previous) previous = ''
                if (!current) current = ''
                return previous + this.separator + current;
            });
        },
        showFirmLog(firmId) {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/firmsLog/show/' + `${firmId}`)
                .then((response) => {
                    this.firmsLog = response.data;
                })
                .catch(error => {
                });
        },
        deleteFirm(id) {
            if (confirm("Видалити контрагента?")) {
                this.axios
                    .delete(process.env.MIX_APP_URL + '/api/firms/delete/' + `${id}`)
                    .then(response => {
                        let i = this.firms.map(item => item.id).indexOf(id);
                        this.firms.splice(i, 1)
                        alert('Ви видалили контрагента')
                    }).catch(error => {
                })
                    .finally(() => this.$router.push({name: 'firms'}))
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
</style>
