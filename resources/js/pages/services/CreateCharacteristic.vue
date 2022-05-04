<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Додавання нової характеристики</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <form @submit.prevent="serviceCreate">

                    <!--                    TODO: Не понятно зачем, но без него не работает-->
                    <input type="hidden" class="form-control" v-model="services">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label>Матеріал</label>
                                <select class="custom-select d-block w-100"
                                        v-bind:class="{ 'is-invalid': error_parent_id }"
                                        v-model="service.parent_id">
                                    <option v-for="material in materials" v-bind:value="material.id">
                                        {{ material.name }}
                                    </option>
                                </select>
                                <span class="invalid-feedback" role="alert" v-for="item in error_parent_id">
                                        <strong>{{ item }}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label>Характеристика</label>
                                <input type="text" class="form-control"
                                       v-bind:class="{ 'is-invalid': error_name }"
                                       v-model="service.name">
                                <span class="invalid-feedback" role="alert" v-for="item in error_name">
                                        <strong>{{ item }}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary pull-right">Додати
                        </button>
                        <router-link :to="{ name : 'services' }"
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
    name: "CreateCharacteristic",
    data() {
        return {
            service: {},
            services: [],
            materials: [],
            error_parent_id: '',
            error_name: '',
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/services')
            .then(response => {
                this.services = response.data
                let i = 0
                for (let key in this.services) {
                    if (this.services[key]['parent_id'] == 0) {
                        this.materials[i] = {
                            name: this.services[key].name,
                            id: this.services[key].id
                        }
                        i++
                    }
                }
            });
    },
    methods: {
        serviceCreate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/services/create', this.service)
                .then((response) => {
                    alert('Ви додали нову характеристику')
                    this.$router.push({name: 'services'})
                })
                .catch(error => {
                    this.error_parent_id = error.response.data.errors.parent_id
                    this.error_name = error.response.data.errors.name
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
