<template>
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body p-4">
                <form action="#" @submit.prevent="login">
                    <h1>С возвращением!</h1>
                    <hr>
                    <div class="mb-4">
                        <input type="email" v-model="form.email" class="form-control" placeholder="Адрес почты электронной">
                    </div>
                    <div class="mb-4">
                        <input type="password"  v-model="form.password" class="form-control" placeholder="Пароль">
                    </div>
                    <p class="text-danger" v-if="error">
                        <small>Не получилось вас авторизовать</small>
                    </p>
                    <button class="btn btn-primary btn-lg w-100">Внедриться в систему</button>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {mapMutations} from "vuex";

export default {
    name: "Login",
    data() {
        return {
            form: {},
            error: false
        }
    },
    methods: {
        ...mapMutations([
            'setUser'
        ]),
        login: function () {
            this.error = null
            fetch(`/api/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.form)
            })
                .then(response => {
                    if (!response.ok) this.error = true
                    else response.json().then(json => {
                        this.setUser(json)
                        localStorage.setItem('_cms_user', JSON.stringify(json))
                        this.$router.push({ name: 'Pages' })
                    })
                })
        }
    }
}
</script>
