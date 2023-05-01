<template>
    <div class="vh-100 editor-page bg-white" v-if="post.id">
        <div class="px-3 d-flex justify-content-between align-items-center border-bottom">
            <router-link :to="{name: 'Posts', params: {postType: postType}}" class="btn btn-sm btn-light">
                <i class="fas fa-chevron-left"></i>
                Назад
            </router-link>
            <div>
                <a :href="`/${postType}/${post.slug}`" class="btn btn-sm btn-light me-2" target="_blank">
                    Посмотреть, что получилось
                </a>
                <button type="button" class="btn btn-sm btn-success" @click="save()">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="saving"></span>
                    Сохранить
                </button>
            </div>
        </div>
        <div class="editor-wrapper">
            <div class="editor-tree border-end overflow-auto p-3">
                <tree-item :block="post" :depth="0" :order="0" :count="post.blocks.length"
                           @update="loadPost"></tree-item>
            </div>
            <div class="editor-fields p-3 overflow-auto">
                <template v-if="activeElement">
                    <field :block="activeElement" @update="loadPost"></field>
                </template>
                <template v-else>
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label>Название</label>
                            <input type="text" class="form-control" v-model="post.title" placeholder="Название">
                        </div>
                        <div class="mb-4 col-md-6">
                            <label>Фрагмент урла</label>
                            <input type="text" class="form-control" v-model="post.slug" placeholder="Латинские буквы, цифры и дефис">
                        </div>
                    </div>
                    <div class="mb-4" v-for="field in post.content">
                        <label>{{ field.title }}</label>
                        <component :is="`${field.type}-field`" :field="field"></component>
                    </div>
                    <hr class="mb-4">
                    <template v-if="post.relations.length">
                        <h4 class="mb-3">Отношения модели</h4>
                        <div class="row mb-4" v-for="relation in post.relations" :key="relation.id">
                            <div class="col-lg-6">
                                <component :model="post"
                                           :relation="relation"
                                           :is="relation.type"></component>
                            </div>
                        </div>
                        <hr class="mb-4">
                    </template>
                    <template v-if="post.inverse_relations?.length">
                        <h4 class="mb-3">Используется в отношениях</h4>
                        <div class="mb-4 row" v-for="relation in post.inverse_relations"
                             :key="relation.id">
                            <div class="col-lg-6">
                                <div class="mb-2">Модель: {{ relation.post_type?.title }}</div>
                                <div class="mb-2">Название: {{ relation.title }}</div>
                                <div class="mb-3">Тип отношения: {{ relation.type }}</div>
                                <div class="btn-group w-100 border mb-2" v-for="relatedPost in relation.related_posts"
                                     :key="relatedPost.id">
                                    <div class="w-100 px-3 align-self-center">{{ relatedPost?.title }}</div>
                                    <router-link :to="{name: 'Post', params: {postType: relation.post_type?.slug, id: relatedPost?.id}}" target="_blank"
                                                 type="button" class="btn btn-light">
                                        <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-4">
                    </template>
                    <MetaFields :meta="post.meta"></MetaFields>
                </template>
            </div>
        </div>
    </div>
    <div class="text-center" v-else>
        <div class="spinner-border my-5 text-secondary" role="status">
            <span class="sr-only">Загружаем...</span>
        </div>
    </div>
</template>

<script>
import MetaFields from "../../components/MetaFields.vue";
import {mapState, mapMutations} from "vuex";

export default {
    name: "Post",
    props: ['postType', 'id'],
    components: {MetaFields},
    computed: {
        ...mapState([
            'activeElement'
        ])
    },
    data() {
        return {
            post: {},
            saving: false,
            tab: 'general'
        }
    },
    watch: {
        tab: function () {
            location.hash = `#${this.tab}`
        }
    },
    methods: {
        save: function () {
            this.saving = true
            this.postJson(`/api/posts/${this.postType}/${this.id}`, this.post, () => {
                this.saving = false
                this.loadPost()
            })
        },
        loadPost: function () {
            this.post = {}
            this.getJson(`/api/posts/${this.postType}/${this.id}`, json => {
                this.post = json
                if (this.activeElement) {
                    this.resetActiveElement(this.post.blocks)
                }
            })
        },
        ...mapMutations([
            'setPostTypes',
            'setPrimitives',
            'setPresets',
            'setComponents',
            'setActiveElement',
            'setCollapsedNodes'
        ])
    },
    mounted() {
        this.loadPost()
        this.getJson(`/api/post-types`, json => this.setPostTypes(json))
        this.getJson(`/api/primitives`, json => this.setPrimitives(json))
        this.getJson(`/api/presets`, json => this.setPresets(json))
        this.getJson(`/api/components`, json => this.setComponents(json))
        this.setActiveElement(null)
        this.setCollapsedNodes([])
    }
}
</script>
