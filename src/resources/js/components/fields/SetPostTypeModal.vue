<template>
    <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#set-post-type">
        <i class="fas fa-plus"></i>
        Вывести посты
    </a>
    <div class="modal fade" tabindex="-1" id="set-post-type">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выбрать модель</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped mb-4">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="postType in postTypes" :key="postType.id">
                            <tr>
                                <td>{{ postType.id }}</td>
                                <td>
                                    {{ postType.title }}
                                </td>
                                <td class="text-nowrap text-end">
                                    <a href="#" data-bs-dismiss="modal" class="btn btn-light me-2" @click.prevent="setPostType(postType)">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <router-link :to="{name: 'Posts', params: {postType: postType.slug}}" class="btn btn-light me-2" target="_blank">
                                        <i class="fas fa-list"></i>
                                    </router-link>
                                    <router-link :to="{name: 'PostType', params: {id: postType.id}}" class="btn btn-light me-2" target="_blank">
                                        <i class="fas fa-pen"></i>
                                    </router-link>
                                </td>
                            </tr>
                        </template>
                        <tr v-if="!postTypes.length">
                            <td colspan="5" class="text-center py-3">
                                Пока нет моделей
                                <br>
                                <br>
                                <router-link class="btn btn-outline-dark" :to="{name: 'PostTypes'}" target="_blank">Создать первую модель</router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "SetPostTypeModal",
    props: {
        block: {
            type: Object
        }
    },
    emits: ['update'],
    computed: {
        ...mapState([
            'postTypes'
        ])
    },
    methods: {
        setPostType: function (postType) {
            this.postJson(`/api/blocks/${this.block.id}/post-type/${postType.id}`, {
                query: {
                    select: 'all'
                }
            }, () => {
                this.$emit('update')
                this.hideModal()
            })
        }
    }
}
</script>
