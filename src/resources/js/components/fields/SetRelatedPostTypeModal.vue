<template>
    <template v-if="blockSources.length">
        <a href="#" class="btn btn-light ms-2" data-bs-toggle="modal" data-bs-target="#set-related-post-type">
            <i class="fas fa-plus"></i>
            Вывести связанные посты
        </a>
    </template>
    <div class="modal fade" tabindex="-1" id="set-related-post-type">
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
                        <template v-for="relation in blockSources" :key="relation.id">
                            <tr>
                                <td>{{ relation.id }}</td>
                                <td>
                                    {{ relation.title }}
                                </td>
                                <td class="text-nowrap text-end">
                                    <a href="#" data-bs-dismiss="modal" class="btn btn-light me-2"
                                       @click.prevent="setRelatedPostType(relation)">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </td>
                            </tr>
                        </template>
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
    name: "SetRelatedPostTypeModal",
    props: {
        block: {
            type: Object
        }
    },
    emits: ['update'],
    computed: {
        ...mapState([
            'postTypes'
        ]),
        blockSources: function () {
            if (!this.block.postType) return []
            return this.block.postType?.relations.map(relation => ({
                id: relation.id,
                inverse: false,
                post_type_id: relation.related_post_type.id,
                title: relation.related_post_type.title
            }))
                .concat(
                    this.block.postType?.inverse_relations.map(relation => ({
                        id: relation.id,
                        inverse: true,
                        post_type_id: relation.post_type.id,
                        title: relation.post_type.title
                    }))
                )
        }
    },
    methods: {
        setRelatedPostType: function (relation) {
            this.postJson(`/api/blocks/${this.block.id}/post-type/${relation.post_type_id}`, {
                query: {
                    relation: relation.id,
                    inverse: relation.inverse
                }
            }, () => {
                this.$emit('update')
                this.hideModal()
            })
        }
    }
}
</script>
