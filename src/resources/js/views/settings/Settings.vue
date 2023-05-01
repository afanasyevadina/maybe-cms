<template>
    <div class="p-4">
        <h1 class="mb-4">Настройки</h1>
        <div class="text-center" v-if="loading">
            <div class="spinner-border my-5 text-secondary" role="status">
                <span class="sr-only">Загружаем...</span>
            </div>
        </div>
        <template v-else>
            <div class="row mb-4" v-for="setting in settings" :key="setting.id">
                <div class="col-sm-4 col-lg-3">{{ setting.title }}</div>
                <div class="col-sm col-lg-6 col-xl-4" v-if="setting.type === 'select'">
                    <select v-model="setting.value" class="form-control">
                        <option :value="null">-</option>
                        <option :value="optionKey" v-for="(option, optionKey) in setting.options" :key="optionKey">{{ option }}</option>
                    </select>
                </div>
                <div class="col-sm col-lg-6 col-xl-4" v-if="setting.type === 'text'">
                    <input type="text" class="form-control" autocomplete="off" v-model="setting.value">
                </div>
            </div>
            <button class="btn btn-success" @click="save">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="saving"></span>Сохранить
            </button>
        </template>
    </div>
</template>

<script>
export default {
    name: 'Settings',
    data() {
        return {
            settings: [],
            loading: true,
            saving: false
        }
    },
    methods: {
        save: function () {
            this.saving = true
            this.postJson(`/api/settings`, {
                settings: this.settings.map(setting => ({slug: setting.slug, value: setting.value}))
            },() => {
                this.saving = false
            })
        }
    },
    mounted() {
        this.getJson(`/api/settings`,json => {
            this.settings = json
            this.loading = false
        })
    }
}
</script>
