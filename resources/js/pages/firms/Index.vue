<template>
    <div class="container-2xl">

        <div class="py-3 text-center">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <h4 div class="text-center">Контрагенти</h4>
                </div>
                <div class="col-sm-3 text-right">
                    <router-link v-if="$auth.check(['admin', 'accountant'])"
                                 :to="{name: 'firms.create'}" class="btn btn-outline-secondary">
                        Новий
                    </router-link>
                    <download-excel
                        class="download-excel"
                        :data="firms"
                        :fields="json_fields"
                        :type="'xls'"
                        :name="fileName"
                        :stringifyLongNum="true">
                        <button type="button" class="btn btn-outline-secondary">
                            Excel
                            <fa-layer class="fa-1x">
                                <fa-icon :icon="['fa', 'download']" style="color:grey; cursor:pointer;"/>
                            </fa-layer>
                        </button>
                    </download-excel>
                </div>
            </div>
        </div>

        <div>
            <vue-good-table
                :columns="columns"
                :rows="firms"
                :sort-options="{
                    enabled: true,
                }"
                :pagination-options="{
                    enabled: true,
                    nextLabel: 'наступна',
                    prevLabel: 'попередня',
                    rowsPerPageLabel: 'Рядки на сторінці',
                    ofLabel: 'з',
                    pageLabel: 'сторінки',
                    allLabel: 'Всі',
                    perPage: 30,
                    position: 'bottom'
                }"
                :class="table_class"
                :line-numbers="true"
                :search-options="{
                    enabled: true,
                    placeholder: 'Пошук в таблиці',
                }"
            >
                <div slot="emptystate" class="text-center">
                    Записів не знайдено
                </div>

                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field === 'Скорочена назва'">
                        <router-link :to="{name: 'firms.show', params: { id: props.row.id }}" :title="'Детально'">
                            {{ props.row.firm_name_short }}
                        </router-link>
                    </span>
                    <span v-else-if="props.column.field === 'Дія'">
                        <div class="btn-group text-right">
                            <fa-layer class="fa-1x">
                                <router-link :to="{name: 'firms.show', params: { id: props.row.id }}"
                                             :title="'Детально'">
                                    <fa-icon :icon="['fa', 'eye']"
                                             style="color:Grey"/>
                                </router-link>
                            </fa-layer>
                        </div>
                    </span>
                </template>

            </vue-good-table>
        </div>
    </div>

</template>

<script>
import {VueGoodTable} from 'vue-good-table';

export default {
    components: {
        VueGoodTable,
    },
    data() {
        return {
            table_class: "table table-responsive table-hover table-sm",
            columns: [{
                label: 'Скорочена назва',
                field: 'Скорочена назва'
            },
                {
                    label: 'ЄДРПОУ',
                    field: 'edrpou'
                },
                {
                    label: 'Фактична адреса',
                    field: 'full_addr_fact'
                },
                {
                    label: 'ПІБ керівника',
                    field: 'boss_pib'
                },
                {
                    label: 'Телефон загальний',
                    field: 'phone_shared'
                },
                {
                    label: 'Примітка',
                    field: 'note'
                },
                {
                    label: 'Дія',
                    field: 'Дія',
                },
            ],
            firms: [],
            separator: '',
            json_fields: {
                'Повна назва': 'firm_name',
                'Скорочена назва': 'firm_name_short',
                'Посада керівника': 'boss_position',
                'ПІБ керівника': 'boss_pib',
                'Посада відповідального за роботи': 'work_position',
                'ПІБ відповідального за роботи': 'work_pib',
                'Юридична адреса (Індекс)': {
                    field: 'addr_zip_ur',
                    callback: (value) => {
                        return (value) ? `'${value}` : '';
                    },
                },
                'Юридична адреса (Область)': 'addr_obl_ur',
                'Юридична адреса (Місто (селище, село))': 'addr_city_ur',
                'Юридична адреса (Вулиця)': 'addr_street_ur',
                'Юридична адреса (Будинок)': 'addr_house_ur',
                'Юридична адреса (Офіс (приміщення))': 'addr_office_ur',
                'Фактична адреса (Індекс)': {
                    field: 'addr_zip_fact',
                    callback: (value) => {
                        return (value) ? `'${value}` : '';
                    },
                },
                'Фактична адреса (Область)': 'addr_obl_fact',
                'Фактична адреса (Місто (селище, село))': 'addr_city_fact',
                'Фактична адреса (Вулиця)': 'addr_street_fact',
                'Фактична адреса (Будинок)': 'addr_house_fact',
                'Фактична адреса (Офіс (приміщення))': 'addr_office_fact',
                'Код ЄДРПОУ': {
                    field: 'edrpou',
                    callback: (value) => {
                        return (value) ? `'${value}` : '';
                    },
                },
                'ІПН': {
                    field: 'ipn',
                    callback: (value) => {
                        return (value) ? `'${value}` : '';
                    },
                },
                'Оподаткування': 'tax',
                'Назва банку': 'bank_name',
                'Номер рахунку': 'account_number',
                'МФО банку': {
                    field: 'bank_mfo',
                    callback: (value) => {
                        return (value) ? `'${value}` : '';
                    },
                },
                'Телефон загальний': 'phone_shared',
                'Email загальний': 'email_shared',
                'Телефон бухгалтера': 'phone_acc',
                'Email бухгалтера': 'email_acc',
                'Телефон відповідального за роботи': 'phone_work',
                'Email відповідального за роботи': 'email_work',
                'Перевізник (Назва)': 'carr_name',
                'Перевізник (Місто)': 'carr_city',
                'Перевізник (Відділення)': 'carr_dep',
                'Перевізник (ПІБ отримувача)': 'carr_pib',
                'Перевізник (Телефон отримувача)': 'carr_phone',
                'Примітка': 'note',
            },
            json_meta: [
                [
                    {
                        key: "charset",
                        value: "utf-8",
                    },
                ],
            ],
            fileName: 'Перелік контрагентів',
        }
    },
    created() {
        this.axios
            .get(process.env.MIX_APP_URL + '/api/firms')
            .then(response => {
                this.firms = response.data
                for (let key in this.firms) {
                    this.firms[key]['full_addr_fact'] = this.allInOne(this.firms[key]['addr_city_fact'], this.firms[key]['addr_street_fact'], this.firms[key]['addr_house_fact'], this.firms[key]['addr_office_fact'])
                }
            });
    },
    methods: {
        allInOne(...theArgs) {
            return theArgs.reduce((previous, current) => {
                this.separator = (!previous || !current) ? '' : ', '
                if (!previous) previous = ''
                if (!current) current = ''
                return previous + this.separator + current
            });
        }
    }
}
</script>

<style scoped>
.container-2xl {
    margin: 100px 50px;
}

.vgt-left-align a {
    color: #212529;
}

.download-excel {
    display: inline-block;
}
</style>

<style>
/*см. invoices/Index.vue*/
</style>
