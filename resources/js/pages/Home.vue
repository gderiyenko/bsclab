<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-center">Контрагенти, у яких відсутні акти</h4>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped text-center">
                <thead class="thead thead-dark">
                <tr>
                    <th class="text-left">Скорочена назва</th>
                    <th>Статут</th>
                    <th>Виписка</th>
                    <th>Витяг</th>
                    <th>НДС</th>
                    <th>Наказ</th>
                    <th>Файл протоколу</th>
                    <th>Договір</th>
                    <th>Рахунок</th>
                    <th>Сплачено</th>
                    <th>Акт</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="firmsNoActs.length">
                    <tr v-for="firm in firmsNoActs">
                        <td class="text-left">
                            <router-link :to="{name: 'firms.show', params: { id: firm.firmId }}"
                                         :title="'Детально'">
                                {{ firm.firmNameShort }}
                            </router-link>
                        </td>
                        <td class="text-center">
                            <fa-layer class="fa-1x text-center">
                                <fa-icon v-if="firm.isStatutFile"
                                         :icon="['fa', 'check']" style="color:Green;"/>
                                <fa-icon v-else
                                         :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td>
                            <fa-layer class="fa-1x">
                                <fa-icon v-if="firm.isVypyskaFile"
                                         :icon="['fa', 'check']" style="color:Green;"/>
                                <fa-icon v-else
                                         :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td>
                            <fa-layer class="fa-1x">
                                <fa-icon v-if="firm.isVytyahFile"
                                         :icon="['fa', 'check']" style="color:Green;"/>
                                <fa-icon v-else
                                         :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td>
                            <fa-layer class="fa-1x">
                                <fa-icon v-if="firm.isNdsFile"
                                         :icon="['fa', 'check']" style="color:Green;"/>
                                <fa-icon v-else
                                         :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td>
                            <fa-layer class="fa-1x">
                                <fa-icon v-if="firm.isNakazFile"
                                         :icon="['fa', 'check']" style="color:Green;"/>
                                <fa-icon v-else
                                         :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td>
                            <fa-layer class="fa-1x">
                                <fa-icon v-if="firm.isProtocolFile"
                                         :icon="['fa', 'check']" style="color:Green;"/>
                                <fa-icon v-else
                                         :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td v-if="firm.contractNumber" style="color:Green;">
                            <b>№ {{ firm.contractNumber }}</b>
                        </td>
                        <td v-else>
                            <fa-layer class="fa-1x">
                                <fa-icon :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td v-if="firm.invoiceNumber" style="color:Green;">
                            <b>№ {{ firm.invoiceNumber }}</b>
                        </td>
                        <td v-else>
                            <fa-layer class="fa-1x">
                                <fa-icon :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td>
                            <fa-layer class="fa-1x">
                                <fa-icon v-if="Number(firm.invoiceAmount) != 0 && Number(firm.invoiceAmount) - Number(firm.paymentAmount) == 0"
                                         :icon="['fa', 'check']" style="color:Green;"/>
                                <fa-icon v-else
                                         :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                        <td v-if="firm.actNumber" style="color:Green;">
                            <b>№ {{ firm.actNumber }}</b>
                        </td>
                        <td v-else>
                            <fa-layer class="fa-1x">
                                <fa-icon :icon="['fa', 'minus']" style="color:Tomato;"/>
                            </fa-layer>
                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td align="center" colspan="11"><b>Контрагенти відсутні</b></td>
                    </tr>
                </template>

                </tbody>
            </table>
        </div>

        <div class="py-3 text-center marg">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-center">Контрагенти, у яких закінчується договір</h4>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="thead text-left thead-dark">
                <tr>
                    <th>Скорочена назва</th>
                    <th>ЄДРПОУ</th>
                    <th>Фактична адреса</th>
                    <th>ПІБ керівника</th>
                    <th>Телефон загальний</th>
                    <th>Дата закінчення договору</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="contracts.length">
                    <tr v-for="contract in endingContracts" :key="contract.id">
                        <td>
                            <router-link :to="{name: 'firms.show', params: { id: contract.firm.id }}"
                                         :title="'Детально'">
                                {{ contract.firm.firm_name_short }}
                            </router-link>
                        </td>
                        <td>{{ contract.firm.edrpou }}</td>
                        <td>{{ contract.firm.full_addr_fact }}</td>
                        <td>{{ contract.firm.boss_pib }}</td>
                        <td>{{ contract.firm.phone_shared }}</td>
                        <td>{{ contract.date_end.slice(0, 10) }}</td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td align="center" colspan="6"><b>Контрагенти відсутні</b></td>
                    </tr>
                </template>

                </tbody>
            </table>
        </div>

        <div class="py-3 text-center marg">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-center">10 нових контрагентів</h4>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="thead text-left thead-dark">
                <tr>
                    <th>Скорочена назва</th>
                    <th>ЄДРПОУ</th>
                    <th>Фактична адреса</th>
                    <th>ПІБ керівника</th>
                    <th>Телефон загальний</th>
                    <th>Дата додавання контрагента</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="firms.length">
                    <tr v-for="firm in newFirmsTop10" :key="firm.id">
                        <td>
                            <router-link :to="{name: 'firms.show', params: { id: firm.id }}" :title="'Детально'">
                                {{ firm.firm_name_short }}
                            </router-link>
                        </td>
                        <td>{{ firm.edrpou }}</td>
                        <td>{{ firm.full_addr_fact }}</td>
                        <td>{{ firm.boss_pib }}</td>
                        <td>{{ firm.phone_shared }}</td>
                        <td>{{ firm.created_at.slice(0, 10) }}</td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td align="center" colspan="6"><b>Контрагенти відсутні</b></td>
                    </tr>
                </template>

                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            firms: [],
            firmsEmpty: [],
            newFirmsTop10: [],
            firmsNoActs: [],
            contracts: [],
            endingContracts: [],
            invoices: [],
            invoicesNoAct: [],
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/firms/noActs')
            .then(response => {
                this.firmsNoActs = response.data
                console.log(this.firmsNoActs)
            })
            .catch(error => {
            });
        this.axios
            .get(process.env.MIX_APP_URL + '/api/invoices')
            .then(response => {
                this.invoices = response.data
                this.invoicesNoAct = this.invoices.filter(function (el) {
                    return !el.act_number
                })
            })
            .catch(error => {
            });
        this.axios
            .get(process.env.MIX_APP_URL + '/api/contracts')
            .then(response => {
                this.contracts = response.data
                let nowPlusMonth = new Date()
                nowPlusMonth.setMonth(new Date().getMonth() + 1)
                nowPlusMonth = nowPlusMonth.toISOString().slice(0, 10);
                let now = new Date().toISOString().slice(0, 10);
                this.endingContracts = this.contracts.filter(function (el) {
                    return (el.date_end > now && el.date_end < nowPlusMonth)
                }).sort(this.byFieldAsc('date_end'))
                for (let key in this.endingContracts) {
                    this.endingContracts[key]['firm']['full_addr_fact'] = this.allInOne(this.endingContracts[key]['firm']['addr_city_fact'], this.endingContracts[key]['firm']['addr_street_fact'], this.endingContracts[key]['firm']['addr_house_fact'])
                }
            })
            .catch(error => {
            });
        this.axios
            .get(process.env.MIX_APP_URL + '/api/firms/')
            .then((response) => {
                this.firms = response.data
                this.newFirmsTop10 = this.firms.sort(this.byFieldDesc('created_at')).slice(0, 9)
                for (let key in this.newFirmsTop10) {
                    this.newFirmsTop10[key]['full_addr_fact'] = this.allInOne(this.newFirmsTop10[key]['addr_city_fact'], this.newFirmsTop10[key]['addr_street_fact'], this.newFirmsTop10[key]['addr_house_fact'])
                }
                this.firmsEmpty = this.firms.filter(function (el) {
                    return (!el.isContract || !el.isInvoice)
                })
            })
            .catch(error => {
            });
    },
    methods: {
        byFieldAsc(field) {
            return (a, b) => a[field] < b[field] ? -1 : 1;
        },
        byFieldDesc(field) {
            return (a, b) => a[field] > b[field] ? -1 : 1;
        },
        allInOne(...theArgs) {
            return theArgs.reduce((previous, current) => {
                this.separator = (!previous || !current) ? '' : ', '
                if (!previous) previous = ''
                if (!current) current = ''
                return previous + this.separator + current
            });
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

.marg {
    margin-top: 50px;
}
</style>
