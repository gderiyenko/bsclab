<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Новий користувач</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="userCreate">
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Ім'я</label>
                            <input type="text" class="form-control"
                                   v-bind:class="{ 'is-invalid': error_name }"
                                   v-model="user.name">
                            <span class="invalid-feedback" role="alert" v-for="item in error_name">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Пароль</label>
                            <input type="text" class="form-control"
                                   v-bind:class="{ 'is-invalid': error_password }"
                                   v-model="user.password">
                            <span class="invalid-feedback" role="alert" v-for="item in error_password">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control"
                                   v-bind:class="{ 'is-invalid': error_email }"
                                   v-model="user.email">
                            <span class="invalid-feedback" role="alert" v-for="item in error_email">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Роль</label>
                            <select class="form-control"
                                    v-bind:class="{ 'is-invalid': error_role }"
                                    v-model="user.role">
                                <option v-for="roleItem in roles" v-bind:value="roleItem.value">
                                    {{ roleItem.text }}
                                </option>
                            </select>
                            <span class="invalid-feedback" role="alert" v-for="item in error_role">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary pull-right">Додати
                        </button>
                        <router-link :to="{ name : 'users' }"
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
            user: {},
            selected: '',
            roles: [
                {text: 'Працівник', value: 'worker'},
                {text: 'Бухгалтер', value: 'accountant'},
                {text: 'Адміністратор', value: 'admin'}
            ],
            error_name: '',
            error_password: '',
            error_email: '',
            error_role: '',
        }
    },
    methods: {
        userCreate() {
            this.axios
                .post(process.env.MIX_APP_URL + '/api/users/create', this.user)
                .then((response) => {
                    alert('Ви додали нового користувача')
                    this.$router.push({name: 'users'})
                })
                .catch(error => {
                    this.error_name = error.response.data.errors.name
                    this.error_password = error.response.data.errors.password
                    this.error_email = error.response.data.errors.email
                    this.error_role = error.response.data.errors.role
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
