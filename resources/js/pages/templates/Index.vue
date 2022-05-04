<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <h4 class="text-center">Завантажені шаблони документів</h4>
                </div>
                <div class="col-sm-3 text-right">
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'templates.create'}" class="btn btn-outline-secondary pull-right">
                        Новий шаблон
                    </router-link>

                    <Legend></Legend>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead text-left thead-dark">
                <tr>
                    <th>Назва</th>
                    <th>Тип</th>
                    <th class="text-right pr-5">Дія</th>
                </tr>
                </thead>
                <tbody>

                <template v-if="templates.length">
                    <tr v-for="template in templates" :key="template.id">
                        <td>{{ template.name }}</td>
                        <td>{{ convertType(template.type) }}</td>
                        <td class="text-right">

                            <fa-layer class="fa-1x" v-if="$auth.check(['admin', 'accountant'])">
                                <router-link :to="{name: 'templates.edit', params: { id: template.id }}"
                                             :title="'Редагувати'">
                                    <fa-icon :icon="['fa', 'pencil-alt']"
                                             style="color:Grey"/>
                                </router-link>
                            </fa-layer>

                            <span v-if="$auth.check(['admin', 'accountant'])"
                                  @click="deleteTemplate(template.id)" :title="'Видалити'">
                                <fa-layer class="fa-1x">
                                    <fa-icon :icon="['fa', 'trash']" style="color:Tomato; cursor:pointer;"/>
                                </fa-layer>
                            </span>

                            <span @click="downloadTemplate(template.id)" :title="'Завантажити'">
                                <fa-layer class="fa-1x">
                                    <fa-icon :icon="['fa', 'download']" style="color:Grey; cursor:pointer;"/>
                                </fa-layer>
                            </span>

                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td align="center" colspan="4"><b>Шаблони відсутні</b></td>
                    </tr>
                </template>

                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
import Legend from "../../components/Legend";

export default {
    name: "Index",
    components: {Legend},
    data() {
        return {
            templates: [],
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/templates')
            .then(response => {
                this.templates = response.data
            });
    },
    methods: {
        deleteTemplate(id) {
            if (confirm("Видалити шаблон?")) {
                this.axios
                    .delete(process.env.MIX_APP_URL + '/api/templates/delete/' + `${id}`)
                    .then(response => {
                        let i = this.templates.map(item => item.id).indexOf(id);
                        this.templates.splice(i, 1)
                        alert('Ви видалили шаблон')
                    }).catch(error => {
                });
            }
        },
        downloadTemplate(id) {
            this.axios.post(process.env.MIX_APP_URL + '/api/templates/download/' + `${id}`)
                .then(response => {
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
                });
        },
        convertType(value) {
            switch (value) {
                case 'contract':
                    return 'Договір';
                case 'act':
                    return 'Акт';
                case 'invoice':
                    return 'Рахунок';
            }
        },
    }
}
</script>

<style scoped>
.container-2xl {
    margin: 100px 50px;
}

table {
    width: 100%;
    word-break: break-word;
}

.fa-1x {
    margin-right: 20px;
}
</style>
