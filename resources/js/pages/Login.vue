<template>
    <div class="vertical">
        <form class="form-signin" autocomplete="off" @submit.prevent="login" method="post">
            <div class="text-center mb-4">
                <img class="mb-4" :src="logo_login" alt='ТОВ "БСК"' width="144" height="144">
                <h1 class="h3 mb-3 font-weight-normal">Вхід до системи</h1>
            </div>

            <div class="alert alert-danger alert-dismissible fade show" v-if="has_error && !success">
                <strong v-if="error === 'login_error'">Введено помилкові дані!</strong>
                <strong v-else>Помилка, не вдається підключитися до сервера.</strong>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>

            <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email адреса" v-model="email"
                       required autofocus>
                <label for="inputEmail">Email адреса</label>
            </div>

            <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" v-model="password"
                       required>
                <label for="inputPassword">Пароль</label>
            </div>

            <button class="btn btn-lg btn-secondary btn-block btn-flat" type="submit">Вхід</button>
        </form>
    </div>
</template>
<script>
import logo_login from './../../images/logo_login.png';

export default {
    data() {
        return {
            logo_login: logo_login,
            email: null,
            password: null,
            success: false,
            has_error: false,
            error: ''
        }
    },
    mounted() {
        //
    },
    methods: {
        login() {
            // get the redirect object
            let redirect = this.$auth.redirect()
            let app = this

            this.$auth
                .login({
                    data: {
                        email: app.email,
                        password: app.password
                    },
                    rememberMe: true,
                    fetchUser: true
                })
                .then(() => {
                        app.success = true
                        // this.$router.push({name: 'firms'})
                    },
                    function (response) {
                        app.has_error = true
                        app.error = response.response.data.error
                    })
                .catch(function (error) {
                    return Promise.reject(error.response);
                });
        }
    }
}
</script>

<style scoped>
.vertical {
    margin-top: 90px;
}

.bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

@media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
}

.form-signin {
    width: 100%;
    max-width: 420px;
    padding: 15px;
    margin: auto;
}

.form-label-group {
    position: relative;
    margin-bottom: 1rem;
}

.form-label-group input,
.form-label-group label {
    height: 3.125rem;
    padding: .75rem;
}

.form-label-group label {
    position: absolute;
    top: 0;
    left: 0;
    display: block;
    width: 100%;
    margin-bottom: 0; /* Override default `<label>` margin */
    line-height: 1.5;
    color: #495057;
    pointer-events: none;
    cursor: text; /* Match the input under the label */
    border: 1px solid transparent;
    border-radius: .25rem;
    transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
    color: transparent;
}

.form-label-group input::-moz-placeholder {
    color: transparent;
}

.form-label-group input:-ms-input-placeholder {
    color: transparent;
}

.form-label-group input::-ms-input-placeholder {
    color: transparent;
}

.form-label-group input::placeholder {
    color: transparent;
}

.form-label-group input:not(:-moz-placeholder-shown) {
    padding-top: 1.25rem;
    padding-bottom: .25rem;
}

.form-label-group input:not(:-ms-input-placeholder) {
    padding-top: 1.25rem;
    padding-bottom: .25rem;
}

.form-label-group input:not(:placeholder-shown) {
    padding-top: 1.25rem;
    padding-bottom: .25rem;
}

.form-label-group input:not(:-moz-placeholder-shown) ~ label {
    padding-top: .25rem;
    padding-bottom: .25rem;
    font-size: 12px;
    color: #777;
}

.form-label-group input:not(:-ms-input-placeholder) ~ label {
    padding-top: .25rem;
    padding-bottom: .25rem;
    font-size: 12px;
    color: #777;
}

.form-label-group input:not(:placeholder-shown) ~ label {
    padding-top: .25rem;
    padding-bottom: .25rem;
    font-size: 12px;
    color: #777;
}

/* Fallback for Edge
-------------------------------------------------- */
@supports (-ms-ime-align: auto) {
    .form-label-group {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column-reverse;
        flex-direction: column-reverse;
    }

    .form-label-group label {
        position: static;
    }

    .form-label-group input::-ms-input-placeholder {
        color: #777;
    }
}
</style>
