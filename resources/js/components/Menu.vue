<template>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"
         v-if="$auth.check(['admin', 'worker', 'accountant'])">

        <router-link :to="{ name: 'home' }" class="navbar-brand"><img :src="logo_nav" alt='ТОВ "БСК"' class="logo_nav"/>
        </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04"
                aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto">

                <!--Посилання Контрагенти-->
                <li class="nav-item active">
                    <router-link :to="{ name : 'firms' }" class="nav-link">Контрагенти</router-link>
                </li>
                <!--Кінець Посилання Контрагенти-->

                <!--Посилання Контракти-->
                <li class="nav-item active">
                    <router-link :to="{ name : 'contracts' }" class="nav-link">Договори</router-link>
                </li>
                <!--Кінець Посилання Контракти-->

                <!--Посилання Рахунки-->
                <li class="nav-item active">
                    <router-link :to="{ name : 'invoices' }" class="nav-link">Рахунки</router-link>
                </li>
                <!--Кінець Посилання Рахунки-->

                <!--Посилання Акти-->
                <li class="nav-item active">
                    <router-link :to="{ name : 'acts' }" class="nav-link">Акти</router-link>
                </li>
                <!--Кінець Посилання Акти-->

                <!--Посилання Шаблони-->
                <li class="nav-item active">
                    <router-link :to="{ name : 'templates' }" class="nav-link">Шаблони</router-link>
                </li>
                <!--Кінець Посилання Шаблони-->

                <!--Посилання Послуги-->
                <li class="nav-item active">
                    <router-link :to="{ name : 'services' }" class="nav-link">Послуги</router-link>
                </li>
                <!--Кінець Посилання Послуги-->

                <!--Посилання Користувачі-->
                <li class="nav-item active" v-if="$auth.check(['admin'])">
                    <router-link :to="{ name : 'users' }" class="nav-link">Користувачі</router-link>
                </li>
                <!--Кінець Посилання Користувачі-->

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">
                <span class="user-name">{{ $auth.user().name }},</span>
            </ul>
            <ul class="navbar-nav">
                <router-link :to="{ name : 'login' }" v-on:click.native="$auth.logout()" class="nav-link">
                    Вихід
                </router-link>
            </ul>
            <!-- Кінець Посилання Right Side Of Navbar -->
        </div>
    </nav>

</template>

<script>
import logo_nav from './../../images/logo_nav.png';

export default {
    data() {
        return {
            logo_nav: logo_nav,
            routes: {
                // UNLOGGED
                unlogged: [
                    {name: 'Login', path: 'login'}
                ],
            }
        }
    },
    mounted() {
        //
    }
}
</script>

<style scoped>
.navbar {
    height: 40px !important;
}

.logo_nav {
    height: 30px;
    width: 30px;
    max-height: 35px;
}

.user-name {
    color: white;
}
</style>
