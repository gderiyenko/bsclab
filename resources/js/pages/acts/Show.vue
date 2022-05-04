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
                    <h4 class="text-center">Акти контрагента</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'acts.create', params: {firm_id: firm_id}}"
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
                    <th>№ акту</th>
                    <th>Дата акту</th>
                    <th>№ договору</th>
                    <th>№ рахунку</th>
                    <th>Послуги</th>
                    <th class="text-right pr-5">Дія</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="acts.length">
                    <tr v-for="act in acts" :key="act.id">
                        <td>{{ act.number }}</td>
                        <td>{{ act.date }}</td>
                        <td>{{ act.contract_number }}</td>
                        <td>{{ act.invoice_number }}</td>
                        <td>{{ act.number_services }}</td>
                        <td class="text-right">

                            <fa-layer v-if="$auth.check(['admin', 'accountant'])" class="fa-1x">
                                <router-link :to="{name: 'acts.edit', params: { id: act.id }}"
                                             :title="'Редагувати'">
                                    <fa-icon :icon="['fa', 'pencil-alt']"
                                             style="color:Grey"/>
                                </router-link>
                            </fa-layer>

                            <span v-if="$auth.check(['admin'])" @click="deleteAct(act.id)" :title="'Видалити'">
                                <fa-layer class="fa-1x">
                                    <fa-icon :icon="['fa', 'trash']" style="color:Tomato; cursor:pointer;"/>
                                </fa-layer>
                            </span>

                            <span @click="showTemplates(type)">
                                <span v-b-modal="act.number" :title="'Завантажити'">
                                    <fa-layer class="fa-1x">
                                        <fa-icon :icon="['fa', 'download']" style="color:grey; cursor:pointer;"/>
                                    </fa-layer>
                                </span>
                                <b-modal :id="act.number" size="lg" title="Виберіть акт для завантаження"
                                         :hide-footer="true">
                                    <table class="table table-hover w-100 d-block d-md-table table-borderless">
                                        <tbody>
                                            <tr v-for="template in templates"
                                                @click="docxCreate(act.id, template)"
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

                            <span @click="showActLog(act.id)">
                                <span v-b-modal="act.id" :title="'Історія'">
                                    <fa-layer class="fa-1x">
                                        <fa-icon :icon="['fa', 'info']" style="color:DodgerBlue; cursor:pointer;"/>
                                    </fa-layer>
                                </span>
                                <b-modal :id="act.id" size="lg" title="Історія акту контрагента"
                                         :hide-footer="true">
                                    <template v-for="actLog in actsLog">
                                        <h6><strong>Дата: {{ actLog.created_at.slice(0, 10) }}</strong></h6>
                                        <h6>Дія: {{ actLog.action_name }}</h6>
                                        <h6>Користувач: {{ actLog.user_name }}</h6>
                                        <h6>№ акту: {{ actLog.act_number }}</h6>
                                        <h6>Дата акту: {{ actLog.act_date }}</h6>
                                        <h6>№ рахунку: {{ actLog.invoice_number }}</h6>
                                        <h6>Дата протоколу: {{ actLog.protocol_date }}</h6>
                                        <hr>
                                    </template>
                                </b-modal>
                            </span>

                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td align="center" colspan="6"><b>Акти відсутні</b></td>
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
            acts: [],
            actsLog: {},
            type: 'act',
            templates: {},
            firm: {},
            firm_id: '',
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/acts/show/' + `${this.$route.params.id}`)
            .then((response) => {
                this.firm_id = this.$route.params.id
                this.firmShow(this.firm_id)
                this.acts = response.data;
            })
            .catch(error => {
                this.$router.push({name: 'firms'})
            });
    },
    methods: {
        deleteAct(id) {
            if (confirm("Видалити цей акт?")) {
                this.axios
                    .delete(process.env.MIX_APP_URL + '/api/acts/delete/' + `${id}`)
                    .then(response => {
                        let i = this.acts.map(item => item.id).indexOf(id);
                        this.acts.splice(i, 1)
                        alert('Ви видалили акт')
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
        showActLog(actId) {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/actsLog/show/' + `${actId}`)
                .then((response) => {
                    this.actsLog = response.data;
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
