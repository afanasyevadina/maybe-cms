<template>
    <div class="vh-100 editor-page bg-white" v-if="component.id">
        <div class="px-3 d-flex justify-content-between align-items-center border-bottom">
            <router-link :to="{name: 'Components'}" class="btn btn-sm btn-light">
                <i class="fas fa-chevron-left"></i>
                Назад
            </router-link>
            <div>
                <a :href="`/components/${component.id}`" class="btn btn-sm btn-light me-2" target="_blank">
                    Посмотреть, что получилось
                </a>
                <button type="button" class="btn btn-sm btn-success" @click="save()">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="saving"></span>
                    Сохранить
                </button>
            </div>
        </div>
        <div class="editor-wrapper">
            <div class="editor-tree border-end overflow-auto p-3 ps-1">
                <tree-item :block="component" :depth="0" :order="0" :count="component.blocks.length" @update="loadComponent"></tree-item>
            </div>
            <div class="editor-fields p-3 overflow-auto">
                <template v-if="activeElement">
                    <field :block="activeElement" @update="loadComponent"></field>
                </template>
                <template v-else>
                    <div class="mb-4">
                        <label>Название</label>
                        <input type="text" class="form-control" v-model="component.title">
                    </div>
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
import {mapState, mapMutations} from "vuex";

export default {
    name: "Component",
    props: ['id'],
    data() {
        return {
            component: {},
            saving: false
        }
    },
    computed: {
        ...mapState([
            'activeElement',
            'primitives',
            'postTypes',
        ])
    },
    methods: {
        loadComponent: function () {
            this.component = {}
            this.getJson(`/api/components/${this.id}`, json => {
                this.component = json
                if (this.activeElement) {
                    this.resetActiveElement(this.component.blocks)
                }
            })
        },
        save: function () {
            this.saving = true
            this.postJson(`/api/components/${this.id}`, this.component, () => {
                this.saving = false
                this.loadComponent()
            })
        },
        ...mapMutations([
            'setPostTypes',
            'setPrimitives',
            'setPresets',
            'setComponents',
            'setActiveElement',
            'setCollapsedNodes',
        ])
    },
    mounted() {
        this.loadComponent()
        this.getJson(`/api/post-types`, json => this.setPostTypes(json))
        this.getJson(`/api/primitives`, json => this.setPrimitives(json))
        this.getJson(`/api/presets`, json => this.setPresets(json))
        this.getJson(`/api/components`, json => this.setComponents(json))
        this.setActiveElement(null)
        this.setCollapsedNodes([])
    }
}
</script>
