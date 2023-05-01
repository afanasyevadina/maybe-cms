<template>
    <div class="modal fade" tabindex="-1" :id="modalKey">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выбрать компонент</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped mb-4">
                        <tbody v-if="!components.length">
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                Пока нет компонентов
                                <br>
                                <br>
                                <router-link :to="{name: 'Components'}" class="btn btn-outline-dark" target="_blank">Создать первый компонент</router-link>
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
                                        <a href="#" data-bs-dismiss="modal" class="btn btn-light me-2" @click.prevent="$emit('addComponent', component)">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a :href="`/components/${component.id}`" class="btn btn-light me-2" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <router-link :to="{name: 'Component', params: {id: component.id}}" class="btn btn-light me-2" target="_blank">
                                            <i class="fas fa-pen"></i>
                                        </router-link>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </template>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "TreeAddComponentModal",
    props: {
        modalKey: {
            type: String
        }
    },
    computed: {
        ...mapState([
            'components',
        ])
    }
}
</script>
