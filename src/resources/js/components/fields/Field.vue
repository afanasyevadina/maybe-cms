<template>
    <div>
        <div class="mb-4">
            <label>Название блока</label>
            <input type="text" v-model="block.title" required class="form-control">
        </div>
        <div class="row align-items-start">
            <template v-for="field in block.content">
                <div :class="field.w || 'col-12'" class="mb-4">
                    <label>{{ field.title }}</label>
                    <component :is="`${field.field_type}-field`" :field="field" v-if="!field.source"></component>
                    <div class="d-flex mt-2" v-if="field.allow_source && sources(field).length">
                        <label class="me-1">Источник: </label>
                        <select v-model="field.source" class="border-0">
                            <option :value="null">нет</option>
                            <option :value="sourceItem.slug" v-for="sourceItem in sources(field)" :key="sourceItem.slug">{{ sourceItem.title }}</option>
                        </select>
                    </div>
                </div>
            </template>
        </div>
        <div class="mb-4" v-if="block.component?.id">
            <label class="d-block">Компонент</label>
            <router-link :to="{name: 'Component', params: {id: block.component.id}}" class="btn btn-light" target="_blank">
                {{ block.component?.title }}
                <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i>
            </router-link>
        </div>
        <template v-if="block.allow_source">
            <label>Источник</label>
            <div class="mb-4" v-if="!block.postType?.id">
                <SetPostTypeModal :block="block" @update="$emit('update')"></SetPostTypeModal>
            </div>
            <div class="mb-4" v-else>
                <div class="btn btn-light" v-if="block.query?.relation">Связанные посты - {{ block.postType?.title }}</div>
                <template v-else>
                    <router-link :to="{name: 'Posts', params: {postType: block.postType?.slug}}" class="btn btn-light" target="_blank">
                        {{ block.postType?.title }}
                        <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i>
                    </router-link>
                    <SetRelatedPostTypeModal :block="block" @update="$emit('update')" v-if="!block.query.select && !block.query.id"></SetRelatedPostTypeModal>
                </template>
                <br>
                <UnsetPostTypeModal :block="block" @update="$emit('update')" v-if="block.query"></UnsetPostTypeModal>
            </div>
        </template>
    </div>
</template>

<script>
import {mapState} from "vuex";
import SetPostTypeModal from "./SetPostTypeModal.vue";
import SetRelatedPostTypeModal from "./SetRelatedPostTypeModal.vue";
import UnsetPostTypeModal from "./UnsetPostTypeModal.vue";

export default {
    name: "BaseField",
    components: {SetPostTypeModal, SetRelatedPostTypeModal, UnsetPostTypeModal},
    emits: ['update'],
    props: {
        block: {
            type: Object
        }
    },
    computed: {
        ...mapState([
            'postTypes'
        ])
    },
    methods: {
        sources: function (field) {
            if (!this.block.postType) return []
            let fields = [
                {slug: 'title', 'title': 'Название', type: 'text'},
                {slug: 'link', 'title': 'Основная ссылка', type: 'link'},
            ]
                .concat(this.block.postType?.structure?.fields?.map(item => ({...item, slug: `field.${item.slug}`})))
                .concat(
                    this.block.postType?.relations?.filter(v => v.type === 'many-to-one')
                        .map(relation => [
                            {slug: `relation.${relation.id}.title`, 'title': `${relation.related_post_type.title} - Название`, type: 'text'},
                            {slug: `relation.${relation.id}.link`, 'title': `${relation.related_post_type.title} - Основная ссылка`, type: 'link'},
                        ].concat(relation.related_post_type?.structure?.fields?.map(item => ({...item, slug: `relation.${relation.id}.field.${item.slug}`, title: `${relation.related_post_type.title} - ${item.title}`}))).flat()).flat()
                )
                .concat(
                    this.block.postType?.inverse_relations?.filter(v => v.type === 'many-to-one')
                        .map(relation => [
                            {slug: `inverse_relation.${relation.id}.title`, 'title': `${relation.post_type.title} - Название`, type: 'text'},
                            {slug: `inverse_relation.${relation.id}.link`, 'title': `${relation.post_type.title} - Основная ссылка`, type: 'link'},
                        ].concat(relation.post_type?.structure?.fields?.map(item => ({...item, slug: `inverse_relation.${relation.id}.field.${item.slug}`, title: `${relation.post_type.title} - ${item.title}`}))).flat()).flat()
                )
            if (['text', 'single-line-text'].includes(field.field_type)) {
                fields = fields.filter(item => item.type === 'text')
            }
            if (['image'].includes(field.field_type)) {
                fields = fields.filter(item => item.type === 'image')
            }
            if (['video'].includes(field.field_type)) {
                fields = fields.filter(item => item.type === 'video')
            }
            if (['link'].includes(field.field_type)) {
                fields = fields.filter(item => item.type === 'link')
            }
            if (['markdown'].includes(field.field_type)) {
                fields = fields.filter(item => item.type === 'markdown')
            }
            return fields
        }
    }
}
</script>
