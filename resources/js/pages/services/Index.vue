<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                    <h4 class="text-center">Послуги</h4>
                </div>
                <div class="col-sm-4 text-right">
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'services.create.material'}"
                                 class="btn btn-outline-secondary pull-right">
                        Новий матеріал
                    </router-link>
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'services.create.сharacteristic'}"
                                 class="btn btn-outline-secondary pull-right">
                        Нова характеристика
                    </router-link>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead text-left thead-dark">
                <tr>
                    <th>Матеріал</th>
                    <th>Характеристика</th>
                    <th v-if="$auth.check(['admin', 'accountant'])" class="text-right pr-5">Дія</th>
                </tr>
                </thead>
                <tbody>

                <template v-if="services.length">
                    <template v-for="material in services">
                        <template v-if="material.parent_id == 0">
                            <tr>
                                <td>{{ material.name }}</td>
                                <td></td>
                                <td v-if="$auth.check(['admin', 'accountant'])" class="text-right">
                                    <fa-layer class="fa-1x">
                                        <router-link :to="{name: 'services.edit', params: { id: material.id }}"
                                                     :title="'Редагувати'">
                                            <fa-icon :icon="['fa', 'pencil-alt']"
                                                     style="color:Grey"/>
                                        </router-link>
                                    </fa-layer>
                                    <span v-if="$auth.check(['admin'])" @click="deleteService(material.id)"
                                          :title="'Видалити'">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fa', 'trash']" style="color:Tomato; cursor:pointer;"/>
                                        </fa-layer>
                                    </span>
                                </td>
                            </tr>
                            <template v-for="property in services">
                                <tr v-if="material.id == property.parent_id">
                                    <td></td>
                                    <td>{{ property.name }}</td>
                                    <td v-if="$auth.check(['admin', 'accountant'])" class="text-right">
                                        <fa-layer class="fa-1x">
                                            <router-link :to="{name: 'services.edit', params: { id: property.id }}"
                                                         :title="'Редагувати'">
                                                <fa-icon :icon="['fa', 'pencil-alt']"
                                                         style="color:Grey"/>
                                            </router-link>
                                        </fa-layer>
                                        <span v-if="$auth.check(['admin'])" @click="deleteService(property.id)"
                                              :title="'Видалити'">
                                            <fa-layer class="fa-1x">
                                                <fa-icon :icon="['fa', 'trash']" style="color:Tomato; cursor:pointer;"/>
                                            </fa-layer>
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </template>
                    </template>
                </template>

                <template v-else>
                    <tr v-if="$auth.check(['admin', 'accountant'])">
                        <td align="center" colspan="3"><b>Послуги відсутні</b></td>
                    </tr>
                    <tr v-else>
                        <td align="center" colspan="2"><b>Послуги відсутні</b></td>
                    </tr>
                </template>

                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            services: [],
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/services')
            .then(response => {
                this.services = response.data
            });
    },
    methods: {
        deleteService(id) {
            if (confirm("Видалити метеріал/характеристику?")) {
                this.axios
                    .delete(process.env.MIX_APP_URL + '/api/services/delete/' + `${id}`)
                    .then(response => {
                        let i = this.services.map(item => item.id).indexOf(id);
                        this.services.splice(i, 1)
                        alert('Ви видалили метеріал/характеристику')
                    }).catch(error => {
                });
            }
        }
    }
}
</script>

<style scoped>
.container-2xl {
    margin: 100px 50px;
}

.fa-1x {
    margin-right: 20px;
}

table {
    width: 100%;
    word-break: break-word;
}
</style>
