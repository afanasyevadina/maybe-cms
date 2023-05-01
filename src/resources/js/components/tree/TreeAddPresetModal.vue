<template>
    <div class="modal fade" tabindex="-1" :id="modalKey">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выбрать шаблон</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped mb-4">
                        <tbody v-if="!presets.length">
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                Пока нет шаблонов
                                <br>
                                <br>
                                <router-link :to="{name: 'Presets'}" class="btn btn-outline-dark" target="_blank">Создать первый шаблон</router-link>
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
                                        <a href="#" data-bs-dismiss="modal" class="btn btn-light me-2" @click.prevent="$emit('addPreset', preset)">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a :href="`/presets/${preset.id}`" class="btn btn-light me-2" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <router-link :to="{name: 'Preset', params: {id: preset.id}}" class="btn btn-light me-2">
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
    name: "TreeAddPresetModal",
    props: {
        modalKey: {
            type: String
        }
    },
    computed: {
        ...mapState([
            'presets',
        ])
    }
}
</script>
