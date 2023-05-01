<template>
    <div class="vh-100 editor-page bg-white" v-if="page.id">
        <div class="px-3 d-flex justify-content-between align-items-center border-bottom">
            <router-link :to="{name: 'Pages'}" class="btn btn-sm btn-light">
                <i class="fas fa-chevron-left"></i>
                Назад
            </router-link>
            <div>
                <a :href="`/${page.slug}`" class="btn btn-sm btn-light me-2" target="_blank">
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
                <tree-item :block="page" :depth="0" :order="0" :count="page.blocks.length"
                           @update="loadPage"></tree-item>
            </div>
            <div class="editor-fields p-3 overflow-auto">
                <template v-if="activeElement">
                    <field :block="activeElement" @update="loadPage"></field>
                </template>
                <template v-else>
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label>Название страницы</label>
                            <input type="text" class="form-control" v-model="page.title" placeholder="Название страницы">
                        </div>
                        <div class="mb-4 col-md-6">
                            <label>Фрагмент урла</label>
                            <input type="text" class="form-control" v-model="page.slug"
                                   placeholder="Латинские буквы, цифры и дефис">
                        </div>
                    </div>
                    <MetaFields :meta="page.meta"></MetaFields>
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
    name: "Page",
    props: ['id'],
    components: {MetaFields},
    data() {
        return {
            page: {},
            saving: false
        }
    },
    computed: {
        ...mapState([
            'activeElement'
        ])
    },
    methods: {
        loadPage: function () {
            this.page = {}
            this.getJson(`/api/pages/${this.id}`, json => {
                this.page = json
                if (this.activeElement) {
                    this.resetActiveElement(this.page.blocks)
                }
            })
        },
        save: function () {
            this.saving = true
            this.postJson(`/api/pages/${this.id}`, this.page, () => {
                this.saving = false
                this.loadPage()
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
        this.loadPage()
        this.getJson(`/api/post-types`, json => this.setPostTypes(json))
        this.getJson(`/api/primitives`, json => this.setPrimitives(json))
        this.getJson(`/api/presets`, json => this.setPresets(json))
        this.getJson(`/api/components`, json => this.setComponents(json))
        this.setActiveElement(null)
        this.setCollapsedNodes([])
    }
}
</script>
