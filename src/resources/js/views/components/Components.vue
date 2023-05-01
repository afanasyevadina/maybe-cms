<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>Компоненты</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-component" class="btn btn-success" v-if="components.length">Создать еще компонент</a>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-border my-5 text-secondary" role="status">
                    <span class="sr-only">Загружаем...</span>
                </div>
            </div>
            <template v-else>
                <table class="table table-striped mb-4">
                    <tbody v-if="!components.length">
                    <tr>
                        <td colspan="5" class="text-center py-3">
                            Пока нет компонентов
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-component" class="btn btn-outline-dark">Создать первый компонент</a>
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
                        <template v-for="component in components" :key="component.id">
                            <tr>
                                <td>{{ component.id }}</td>
                                <td>{{ component.title }}</td>
                                <td>{{ formatDate(component.updated_at) }}</td>
                                <td class="text-nowrap text-end">
                                    <a :href="`/components/${component.id}`" class="btn btn-light me-2" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <router-link :to="{name: 'Component', params: {id: component.id}}" class="btn btn-light me-2">
                                        <i class="fas fa-pen"></i>
                                    </router-link>
                                    <DeleteComponent :id="component.id"></DeleteComponent>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </template>
                </table>
            </template>
        </div>
        <CreateComponent></CreateComponent>
    </div>
</template>

<script>
import CreateComponent from "./CreateComponent.vue";
import DeleteComponent from "./DeleteComponent.vue";

export default {
    name: 'Components',
    components: {
        CreateComponent,
        DeleteComponent
    },
    data() {
        return {
            components: [],
            loading: true
        }
    },
    mounted() {
        this.getJson(`/api/components`,json => {
            this.components = json
            this.loading = false
        })
    }
}
</script>
