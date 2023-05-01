<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>Шаблоны</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-preset" class="btn btn-success" v-if="presets.length">Создать еще шаблон</a>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-border my-5 text-secondary" role="status">
                    <span class="sr-only">Загружаем...</span>
                </div>
            </div>
            <template v-else>
                <table class="table table-striped mb-4">
                    <tbody v-if="!presets.length">
                    <tr>
                        <td colspan="5" class="text-center py-3">
                            Пока нет шаблонов
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-preset" class="btn btn-outline-dark">Создать первый шаблон</a>
                        </td>
                    </tr>
                    </tbody>
                    <template v-else>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Последнее обновление</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="preset in presets" :key="preset.id">
                            <tr>
                                <td>{{ preset.id }}</td>
                                <td>{{ preset.title }}</td>
                                <td>{{ formatDate(preset.updated_at) }}</td>
                                <td class="text-nowrap text-end">
                                    <a :href="`/presets/${preset.id}`" class="btn btn-light me-2" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <router-link :to="{name: 'Preset', params: {id: preset.id}}" class="btn btn-light me-2">
                                        <i class="fas fa-pen"></i>
                                    </router-link>
                                    <DeletePreset :id="preset.id"></DeletePreset>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </template>
                </table>
            </template>
        </div>
        <CreatePreset></CreatePreset>
    </div>
</template>

<script>
import CreatePreset from "./CreatePreset.vue";
import DeletePreset from "./DeletePreset.vue";

export default {
    name: 'Presets',
    components: {
        CreatePreset,
        DeletePreset
    },
    data() {
        return {
            presets: [],
            loading: true
        }
    },
    mounted() {
        this.getJson(`/api/presets`,json => {
            this.presets = json
            this.loading = false
        })
    }
}
</script>
