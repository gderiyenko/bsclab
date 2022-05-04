<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Редагування шаблону</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <form @submit.prevent="templateUpdate">

                    <div class="mb-3">
                        <div class="form-group">
                            <label><strong>Назва шаблону</strong></label>
                            <input
                                type="text" class="form-control"
                                v-bind:class="{ 'is-invalid': error_name }"
                                v-model="template.name">
                            <span class="invalid-feedback" role="alert" v-for="item in error_name">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary pull-right">Прийняти зміни
                        </button>
                        <router-link :to="{ name : 'templates' }"
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
    name: "Edit",
    data() {
        return {
            template: {},
            error_name: '',
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/templates/edit/' + `${this.$route.params.id}`)
            .then((response) => {
                this.template = response.data;
            })
            .catch(error => {
                this.$router.push({name: 'templates'})
            });
    },
    methods: {
        templateUpdate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/templates/update/' + `${this.$route.params.id}`, this.template)
                .then((response) => {
                    this.$router.push({name: 'templates'});
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
