<template>
    <div class="bg-light">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top" v-if="!$route.meta?.hideNav">
            <div class="container-fluid px-4">
                <router-link class="navbar-brand" :to="{name: 'Pages'}">
                    CMS вроде
                </router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent" v-if="user">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <router-link :to="{name: 'Pages'}" class="nav-link">Страницы</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Presets'}" class="nav-link">Шаблоны</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Components'}" class="nav-link">Компоненты</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'PostTypes'}" class="nav-link">Модели</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Images'}" class="nav-link">Медиа</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Settings'}" class="nav-link">Настройки</router-link>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#" @click.prevent="logout">
                                    Выйти отсюда
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            <router-view :key="$route.path"></router-view>
            <FlashSuccess></FlashSuccess>
            <FlashError></FlashError>
        </main>
    </div>
</template>

<script>
import {mapState} from 'vuex'
import {mapMutations} from 'vuex'
import FlashSuccess from "./components/flash/FlashSuccess.vue";
import FlashError from "./components/flash/FlashError.vue";
export default {
    name: "App",
    components: {FlashSuccess, FlashError},
    computed: {
        ...mapState([
            'user',
        ])
    },
    methods: {
        logout: function () {
            fetch(`/api/logout`, {
                method: 'POST'
            })
                .then(() => {
                    this.unsetUser()
                    this.$router.push({ name: 'Login' })
                })
        },
        ...mapMutations([
            'unsetUser',
            'setUser',
        ]),
    },
    created() {
        if (localStorage.getItem('_cms_user')) {
            this.setUser(JSON.parse(localStorage.getItem('_cms_user')))
        }
    }
}
</script>

<style>
.dropdown-toggle::after {
    display: none;
}
.preview-img {
    aspect-ratio: 16 / 9;
    object-fit: contain;
}
.c-pointer {
    cursor: pointer;
}
.editor-page {
    display: grid;
    grid-template-rows: 42px calc(100vh - 42px);
}
.editor-wrapper {
    display: grid;
    grid-template-columns: 200px 1fr;
}
.tree-node:not(:hover) .dropdown-toggle {
    opacity: 0;
}
.tree-node:hover {
    background-color: #f8f9fa;
}
.alert {
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
}
.select-list {
    max-height: 150px;
}
</style>
