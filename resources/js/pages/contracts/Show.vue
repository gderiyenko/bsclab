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
                    <h4 class="text-center">Договори контрагента</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'contracts.create', params: {firm_id: firm_id}}"
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
                    <th>№ договору</th>
                    <th>Дата договору</th>
                    <th>Дата припинення</th>
                    <th>Статус</th>
                    <th>Примітка</th>
                    <th class="text-right pr-5">Дія</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="contracts.length">
                    <tr v-for="contract in contracts" :key="contract.id" v-bind:style="{ background: contract.color }">
                        <td>{{ contract.number }}</td>
                        <td>{{ contract.date_contract }}</td>
                        <td>{{ contract.date_end }}</td>
                        <td>{{ contract.status }}</td>
                        <td>{{ contract.note }}</td>
                        <td class="text-right">

                            <fa-layer v-if="$auth.check(['admin', 'accountant'])" class="fa-1x">
                                <router-link :to="{name: 'contracts.edit', params: { id: contract.id }}"
                                             :title="'Редагувати'">
                                    <fa-icon :icon="['fa', 'pencil-alt']"
                                             style="color:Grey"/>
                                </router-link>
                            </fa-layer>

                            <span v-if="$auth.check(['admin'])" @click="deleteContract(contract.id)" :title="'Видалити'">
                                <fa-layer class="fa-1x">
                                    <fa-icon :icon="['fa', 'trash']" style="color:Tomato; cursor:pointer;"/>
                                </fa-layer>
                            </span>

                            <span @click="showTemplates(type)">
                                <span v-b-modal="contract.number" :title="'Завантажити'">
                                    <fa-layer class="fa-1x">
                                        <fa-icon :icon="['fa', 'download']" style="color:grey; cursor:pointer;"/>
                                    </fa-layer>
                                </span>
                                <b-modal :id="contract.number" size="lg" title="Виберіть договір для завантаження"
                                         :hide-footer="true">
                                    <table class="table table-hover w-100 d-block d-md-table table-borderless">
                                        <tbody>
                                            <tr v-for="template in templates"
                                                @click="docxCreate(contract.id, template)"
                                                style="cursor:pointer;">
                                                <td>
                                                    {{ template.name }}
                                                </td>
                                                <td class="text-right">
                                                    <fa-layer class="fa-1x">
                                                        <fa-icon :icon="['fa', 'download']" style="color:grey; cursor:pointer;"/>
                                                    </fa-layer>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </b-modal>
                            </span>

                            <span @click="showContractLog(contract.id)">
                                <span v-b-modal="contract.id" :title="'Історія'">
                                    <fa-layer class="fa-1x">
                                        <fa-icon :icon="['fa', 'info']" style="color:DodgerBlue; cursor:pointer;"/>
                                    </fa-layer>
                                </span>
                                <b-modal :id="contract.id" size="lg" title="Історія договору контрагента"
                                         :hide-footer="true">
                                    <template v-for="contractLog in contractsLog">
                                        <h6><strong>Дата: {{ contractLog.created_at.slice(0, 10) }}</strong></h6>
                                        <h6>Дія: {{ contractLog.action_name }}</h6>
                                        <h6>Користувач: {{ contractLog.user_name }}</h6>
                                        <h6>№ договору: {{ contractLog.number }}</h6>
                                        <h6>Дата договору: {{ contractLog.date_contract }}</h6>
                                        <h6>Дата припинення: {{ contractLog.date_end }}</h6>
                                        <h6>Сума: {{ contractLog.amount }}</h6>
                                        <h6>Вид договору: {{ convertType(contractLog.category) }}</h6>
                                        <h6>Примітка: {{ contractLog.note }}</h6>
                                        <hr>
                                    </template>
                                </b-modal>
                            </span>

                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td align="center" colspan="6"><b>Договори відсутні</b></td>
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
            contracts: [],
            contractsLog: {},
            type: 'contract',
            templates: {},
            firm: {},
            firm_id: '',
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/contracts/show/' + `${this.$route.params.id}`)
            .then((response) => {
                this.firm_id = this.$route.params.id
                this.contracts = response.data;
                this.firmShow(this.firm_id)
                let now = new Date();
                let nowPlusMonth = new Date(now)
                nowPlusMonth.setMonth(nowPlusMonth.getMonth() + 1);
                for (let key in this.contracts) {
                    let date_end = new Date(this.contracts[key]['date_end'])
                    this.contracts[key]['color'] = (date_end < nowPlusMonth && date_end > now) ? '#ffffb8' : ''
                    this.contracts[key]['numberDate'] = '№ ' + this.contracts[key]['number'] + ' від '
                        + this.contracts[key]['date_contract']
                }
            })
            .catch(error => {
                this.$router.push({name: 'firms'})
            });
    },
    methods: {
        deleteContract(id) {
            if (confirm("Видалити цей договір?")) {
                this.axios
                    .delete(process.env.MIX_APP_URL + '/api/contracts/delete/' + `${id}`)
                    .then(response => {
                        let i = this.contracts.map(item => item.id).indexOf(id);
                        this.contracts.splice(i, 1)
                        alert('Ви видалили договір')
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
                    //this.$router.push({name: 'firms'})
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
        showContractLog(contractId) {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/contractsLog/show/' + `${contractId}`)
                .then((response) => {
                    this.contractsLog = response.data;
                })
                .catch(error => {
                });
        },
        convertType(contractType) {
            switch (contractType) {
                case 1:
                    return 'одноразовий';
                default:
                    return '';
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
</style>
