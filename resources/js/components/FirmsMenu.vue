<template>
    <div class="col-sm-7">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button @click="firmsShow()" class="btn btn-outline-dark">Інфо</button>
            <button @click="filesShow()" class="btn btn-outline-dark">Документи</button>
            <button @click="contractsShow()" class="btn btn-outline-dark">Договори</button>
            <button @click="invoicesShow()" class="btn btn-outline-dark">Рахунки</button>
            <button @click="paymentsShow()" class="btn btn-outline-dark">Платежі</button>
            <button @click="actsShow()" class="btn btn-outline-dark">Акти</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['firm_id'],
    name: "FirmsMenu",
    data() {
        return {}
    },
    methods: {
        firmsShow() {
            this.$router.push({
                name: 'firms.show',
                params: {
                    id: this.firm_id
                }
            }).catch(() => {
            });
        },
        filesShow() {
            this.$router.push({
                name: 'files.show',
                params: {
                    id: this.firm_id
                }
            }).catch(() => {
            });
        },
        contractsShow() {
            this.$router.push({
                name: 'contracts.show',
                params: {
                    id: this.firm_id
                }
            }).catch(() => {
            });
        },
        invoicesShow() {
            this.$router.push({
                name: 'invoices.show',
                params: {
                    id: this.firm_id
                }
            }).catch(() => {
            });
        },
        paymentsShow() {
            this.$router.push({
                name: 'payments.show',
                params: {
                    id: this.firm_id
                }
            }).catch(() => {
            });
        },
        actsShow() {
            this.$router.push({
                name: 'acts.show',
                params: {
                    id: this.firm_id
                }
            }).catch(() => {
            });
        }
    }
}
</script>

<style scoped>
.row {
    margin: 30px 30px;
}
</style>
