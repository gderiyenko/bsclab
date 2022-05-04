<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <h4 class="text-center">Користувачі системи</h4>
                </div>
                <div class="col-sm-3 text-right">
                    <router-link :to="{name: 'users.log'}" class="btn btn-outline-secondary pull-right">
                        Історія входу
                    </router-link>
                    <router-link :to="{name: 'users.create'}" class="btn btn-outline-secondary pull-right">
                        Новий
                    </router-link>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead text-left thead-dark">
                <tr>
                    <th>Ім'я</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Статус</th>
                    <th class="text-right pr-5">Дія</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ convertRole(user.role) }}</td>
                    <td>{{ convertStatus(user.deleted_at) }}</td>
                    <td class="text-right">
                        <fa-layer class="fa-1x">
                            <router-link :to="{name: 'users.edit', params: { id: user.id }}" :title="'Редагувати'">
                                <fa-icon :icon="['fa', 'pencil-alt']"
                                         style="color:Grey"/>
                            </router-link>
                        </fa-layer>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            users: [],
            value: '',
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/users')
            .then(response => {
                this.users = response.data
            });
    },
    methods: {
        convertRole(value) {
            switch (value) {
                case 'worker':
                    return 'Працівник';
                case 'accountant':
                    return 'Бухгалтер';
                case 'admin':
                    return 'Адміністратор';
            }
        },
        convertStatus(value) {
            return (value ? 'Заблокований' : 'Активний')
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
