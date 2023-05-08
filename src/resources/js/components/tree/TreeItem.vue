<template>
    <div class="d-flex align-items-start">
        <a href="#" data-bs-toggle="collapse" :data-bs-target="`#tree-item-${collapseKey}`" class="btn btn-sm border-0 pe-0 rounded-0" :class="{'collapsed': collapsed, 'fade': !block.blocks.length, 'btn-secondary': block.id === activeElement?.id}" @click="collapsed = !collapsed" v-if="childrenAllowed">
            <i :class="`fas fa-chevron-${collapsed ? 'right' : 'down'}`"></i>
        </a>
        <div class="w-100">
            <div class="d-flex align-items-center tree-node">
                <a href="#" class="btn btn-sm w-100 border-0 text-start rounded-0" :class="{'btn-secondary': block.id === activeElement?.id}" @click.prevent="activate">{{ block.title }} {{block.postType && block.query?.select ? `(${block.postType.plural_title})` : ''}}</a>
                <button class="btn border-0 btn-sm dropdown-toggle rounded-0" :class="{'btn-secondary': block.id === activeElement?.id}" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu py-0">
                    <template v-if="childrenAllowed">
                        <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-primitive-${collapseKey}`">Добавить примитив</a></li>
                    </template>
                    <template v-if="componentAllowed">
                        <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-preset-${collapseKey}`">Использовать шаблон</a></li>
                    </template>
                    <template v-if="presetAllowed">
                        <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-component-${collapseKey}`">Вставить компонент</a></li>
                    </template>
                    <template v-if="block.class_name === 'block'">
                        <li><a class="dropdown-item small px-2" href="#" @click.prevent="cloneBlock">Копировать</a></li>
                        <li><a class="dropdown-item small px-2" href="#" @click.prevent="$emit('moveUp')" v-if="block.order > 1">Выше</a></li>
                        <li><a class="dropdown-item small px-2" href="#" @click.prevent="$emit('moveDown')" v-if="block.order < count">Ниже</a></li>
                        <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#delete-modal-${collapseKey}`">Удалить</a></li>
                    </template>
                </ul>
            </div>
            <div class="collapse" :class="{'show': !collapsed}" :id="`tree-item-${collapseKey}`">
                <tree-item v-for="(childBlock, childBlockIndex) in (block.blocks || []).sort((a, b) => a.order - b.order)" :block="childBlock" :key="childBlock.id" :depth="depth + 1" :order="childBlockIndex" :count="block.blocks.length"
                           @moveUp="moveUp(childBlockIndex)" @moveDown="moveDown(childBlockIndex)" @update="$emit('update')"></tree-item>
            </div>
        </div>
        <TreeDeleteModal @update="$emit('update')" :modalKey="`delete-modal-${collapseKey}`" :block="block"></TreeDeleteModal>
        <TreeAddPrimitiveModal @addBlock="addBlock" :modalKey="`add-primitive-${collapseKey}`" :allowed-primitives="allowedPrimitives"></TreeAddPrimitiveModal>
        <TreeAddPresetModal @addPreset="addPreset" :modalKey="`add-preset-${collapseKey}`" v-if="presetAllowed"></TreeAddPresetModal>
        <TreeAddComponentModal @addComponent="addComponent" :modalKey="`add-component-${collapseKey}`" v-if="componentAllowed"></TreeAddComponentModal>
    </div>
</template>

<script>
import TreeDeleteModal from "./TreeDeleteModal.vue";
import TreeAddPrimitiveModal from "./TreeAddPrimitiveModal.vue";
import TreeAddPresetModal from "./TreeAddPresetModal.vue";
import TreeAddComponentModal from "./TreeAddComponentModal.vue";
import {mapMutations, mapState} from "vuex";

export default {
    name: "TreeItem",
    components: {TreeDeleteModal, TreeAddPresetModal, TreeAddPrimitiveModal, TreeAddComponentModal},
    props: {
        block: {
            type: Object
        },
        depth: {
            type: Number
        },
        order: {
            type: Number
        },
        count: {
            type: Number
        }
    },
    data() {
        return {
            collapsed: true
        }
    },
    watch: {
        collapsed: function() {
            if (this.collapsed) {
                this.setCollapsedNodes(this.collapsedNodes.filter(v => v !== this.block.id))
            } else {
                this.setCollapsedNodes(this.collapsedNodes.concat([this.block.id]))
            }
        }
    },
    computed: {
        ...mapState([
            'primitives',
            'collapsedNodes',
            'activeElement'
        ]),
        collapseKey: function () {
            return `${this.block.class_name}-${this.block.id}`
        },
        blockChildren: function () {
            return (this.block.children || [])
        },
        childrenAllowed: function () {
            return this.block.class_name !== 'block' || this.blockChildren.length
        },
        presetAllowed: function () {
            return this.block.class_name !== 'block' || this.blockChildren.includes('preset')
        },
        componentAllowed: function () {
            return this.block.class_name !== 'block' || this.blockChildren.includes('component')
        },
        allowedPrimitives: function () {
            const primitives = {}
            for (const primitiveKey in this.primitives) {
                if (!!this.blockChildren.includes(primitiveKey) || this.block.class_name !== 'block' && this.primitives[primitiveKey].root) {
                    primitives[primitiveKey] = this.primitives[primitiveKey]
                }
            }
            return primitives
        }
    },
    methods: {
        cloneBlock: function () {
            this.postJson(`/api/blocks/${this.block.id}/clone`, {}, () => {
                this.$emit('update')
            })
        },
        addBlock: function (blockType) {
            this.postJson(`/api/blocks`, {
                type: blockType,
                attachable_id: this.block.id,
                attachable_type: this.block.class_name,
            }, json => {
                this.block.blocks?.push(json)
                this.setActiveElement(json)
            })
        },
        addPreset: function (preset) {
            this.postJson(`/api/presets/${preset.id}/apply`, {
                attachable_type: this.block.class_name,
                attachable_id: this.block.id,
            }, json => {
                this.$emit('update')
            })
        },
        addComponent: function (component) {
            this.postJson(`/api/components/${component.id}/apply`, {
                attachable_type: this.block.class_name,
                attachable_id: this.block.id,
            }, json => {
                this.$emit('update')
            })
        },
        activate: function () {
            this.setActiveElement(this.block.class_name === 'block' ? this.block : null)
        },
        moveUp: function (blockIndex) {
            this.block.blocks[blockIndex].order--
            this.block.blocks[blockIndex - 1].order++
        },
        moveDown: function (blockIndex) {
            this.block.blocks[blockIndex].order++
            this.block.blocks[blockIndex + 1].order--
        },
        ...mapMutations([
            'setActiveElement',
            'setCollapsedNodes'
        ])
    },
    mounted() {
        this.collapsed = this.collapsedNodes.length ? !this.collapsedNodes.includes(this.block.id) : this.depth > 0
    }
}
</script>
