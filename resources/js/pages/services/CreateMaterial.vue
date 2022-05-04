<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Додавання нового матеріалу</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <form @submit.prevent="serviceCreate">

                    <input type="hidden" class="form-control"
                           v-model="service.parent_id = 0">

                    <div class="mb-3">
                        <div class="form-group">
                            <label>Матеріал</label>
                            <input type="text" class="form-control"
                                   v-bind:class="{ 'is-invalid': error_name }"
                                   v-model="service.name">
                            <span class="invalid-feedback" role="alert" v-for="item in error_name">
                                <strong>{{ item }}</strong>
                            </span>
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
    name: "CreateMaterial",
    data() {
        return {
            service: {},
            error_name: '',
        }
    },
    methods: {
        serviceCreate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/services/create', this.service)
                .then((response) => {
                    alert('Ви додали новий матеріал')
                    this.$router.push({name: 'services'})
                })
                .catch(error => {
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
