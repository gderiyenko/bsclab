<template>
    <div class="container-2xl">

        <div class="row">
            <FirmsMenu :firm_id="id"></FirmsMenu>
            <div class="col-sm-5 text-info text-right">
                <h6><strong>{{ firm.firm_name }}</strong></h6>
            </div>
        </div>

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-center">Установчі документи контрагента</h4>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm">
                <tbody v-for="doc in document_types">
                <tr class="gray-500">
                    <td><strong>{{ doc.name }}</strong></td>
                </tr>
                <tr>
                    <td>
                        <template v-for="file in files">
                            <template v-for="value in file">
                                <div v-if="value == doc.value" @mouseover="show = file.id" @mouseout="show = false"
                                     class="files_row">
                                    <a :href="file['url']" v-bind:target="'_blank'">
                                        <img :src="logo_document" :title="'Показати'" class="logo_document"/>
                                    </a>
                                    <div v-if="$auth.check(['admin'])" v-show="show === file.id">
                                        <button class="btn btn-sm btn-outline-danger" @click="deleteFile(file.id)">
                                            Видалити
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </template>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>

        <hr>
        <br>

        <FileUpload v-if="$auth.check(['admin', 'accountant'])"
                    :firm_id="id" :document_types="document_types"
                    @files-list="filesList">
        </FileUpload>

    </div>
</template>

<script>
import logo_document from '../../../images/logo_document.png';
import FirmsMenu from '../../components/FirmsMenu';
import FileUpload from '../../components/FileUpload';

export default {
    props: ['id'],
    name: "Index",
    components: {
        FirmsMenu,
        FileUpload
    },
    data() {
        return {
            firm: {},
            logo_document: logo_document,
            files: {},
            document_types: [
                {name: 'Статут', value: 'statut'},
                {name: 'Виписка', value: 'vypyska'},
                {name: 'Витяг', value: 'vytyah'},
                {name: 'НДС', value: 'nds'},
                {name: 'Наказ про призначення директора', value: 'nakaz'},
                {name: 'Протокол', value: 'protocol'},
                {name: 'Інше', value: 'other'}
            ],
            show: false,
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/files/show/' + `${this.$route.params.id}`)
            .then((response) => {
                this.files = response.data;
                this.firmShow(this.id)
            })
            .catch(error => {
                this.$router.push({name: 'firms'})
            });
    },
    methods: {
        filesList(data) {
            this.files = data
        },
        deleteFile(id) {
            if (confirm("Видалити цей файл?")) {
                this.axios
                    .delete(process.env.MIX_APP_URL + '/api/files/delete/' + `${id}`)
                    .then(response => {
                        let i = this.files.map(item => item.id).indexOf(id)
                        this.files.splice(i, 1)
                        alert('Ви видалили файл')
                    }).catch(error => {
                });
            }
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

.files_row {
    display: inline-table;
    height: 145px;
}

.logo_document {
    height: 110px;
    width: 110px;
    max-height: 110px;
}

.gray-500 {
    background-color: #adb5bd
}
</style>
