<template>
    <div class="container">

        <div class="py-5 text-center">
            <h4>Додавання нового шаблону</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="templateCreate">
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Назва шаблону</label>
                            <input type="text" class="form-control"
                                   v-bind:class="{ 'is-invalid': error_name }"
                                   v-model="template_name">
                            <span class="invalid-feedback" role="alert" v-for="item in error_name">
                                <strong>{{ item }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Тип шаблону</label>
                            <select class="form-control" v-model="template_type"
                                    v-bind:class="{ 'is-invalid': error_type }">
                                <option :value="undefined" disabled style="display:none">Виберіть тип шаблону</option>
                                <option v-for="typeItem in templateTypes"
                                        v-bind:value="typeItem.value">
                                    {{ typeItem.name }}
                                </option>
                            </select>
                            <span class="invalid-feedback" role="alert" v-for="item in error_type">
                            <strong>{{ item }}</strong>
                        </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Виберіть файл шаблону</label>
                            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"
                                   v-bind:class="{ 'is-invalid': error_file }"/>
                            <span class="invalid-feedback" role="alert" v-for="item in error_file">
                            <strong>{{ item }}</strong>
                        </span>
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="submit" class="btn btn-outline-secondary pull-right">Додати
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
    name: "Create",
    data() {
        return {
            template: {},
            file: [],
            files: [],
            template_name: '',
            template_type: '',
            templateTypes: [
                {name: 'Договір', value: 'contract'},
                {name: 'Акт', value: 'act'},
                {name: 'Рахунок', value: 'invoice'},
            ],
            error_name: '',
            error_type: '',
            error_file: '',
        }
    },
    methods: {
        templateCreate() {
            let formData = new FormData();
            formData.append('name', this.template_name);
            formData.append('type', this.template_type);
            formData.append('file', this.file);
            this.axios
                .post(process.env.MIX_APP_URL + '/api/templates/create',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                alert('Ви додали новий шаблон')
                this.$router.push({name: 'templates'})
            })
                .catch(error => {
                    this.error_name = error.response.data.errors.name
                    this.error_type = error.response.data.errors.type
                    this.error_file = error.response.data.errors.file
                })
                .finally(() => this.loading = false)
        },
        handleFileUpload() {
            this.file = this.$refs.file.files[0]
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
