<template>
    <div>
        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-center">Завантажити документ</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <div class="form-group">
                        <label><strong>Тип документа</strong></label>
                        <select class="form-control" v-model="typeDoc" v-bind:class="{ 'is-invalid': error_title }">
                            <option :value="undefined" disabled style="display:none">Виберіть тип документа</option>
                            <option v-for="typeItem in document_types"
                                    v-bind:value="typeItem.value">
                                {{ typeItem.name }}
                            </option>
                        </select>
                        <span class="invalid-feedback" role="alert" v-for="item in error_title">
                            <strong>{{ item }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label><strong>Виберіть файл</strong></label>
                        <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"
                               v-bind:class="{ 'is-invalid': error_file }"/>
                        <span class="invalid-feedback" role="alert" v-for="item in error_file">
                            <strong>{{ item }}</strong>
                        </span>
                    </div>
                </div>
                <div>
                    <button v-on:click="submitFile()" class="btn btn-outline-secondary pull-right">Додати
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['firm_id', 'document_types'],
    data() {
        return {
            file: [],
            files: [],
            typeDoc: '',
            error_file: '',
            error_title: '',
        }
    },
    methods: {
        submitFile() {
            let formData = new FormData();
            formData.append(this.typeDoc, this.file);
            formData.append('firm_id', this.firm_id);
            formData.append('title', this.typeDoc);
            axios.post(process.env.MIX_APP_URL + '/api/files/upload',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response) => {
                    let res = this.document_types.filter(it => it.value.includes(this.typeDoc));
                    alert('Ви успішно додали ' + res[0].name)
                    this.error_file = ''
                    this.error_title = ''
                    this.file = ' ';
                    this.axios
                        .get(process.env.MIX_APP_URL + '/api/files/show/' + `${this.$route.params.id}`)
                        .then((response) => {
                            this.files = response.data;
                            this.$emit('files-list', this.files)
                            this.file = ' '
                            this.typeDoc = undefined
                        })
                        .catch(error => {
                            this.$router.push({name: 'firms'})
                        });
                })
                .catch(error => {
                    this.error_title = error.response.data.errors.title
                    if (error.response.data.errors.statut) this.error_file = error.response.data.errors.statut
                    if (error.response.data.errors.vypyska) this.error_file = error.response.data.errors.vypyska
                    if (error.response.data.errors.vytyah) this.error_file = error.response.data.errors.vytyah
                    if (error.response.data.errors.nds) this.error_file = error.response.data.errors.nds
                    if (error.response.data.errors.nakaz) this.error_file = error.response.data.errors.nakaz
                    if (error.response.data.errors.protocol) this.error_file = error.response.data.errors.protocol
                    if (error.response.data.errors.other) this.error_file = error.response.data.errors.other
                });
        },
        handleFileUpload() {
            this.file = this.$refs.file.files[0]
        }
    }
}
</script>
