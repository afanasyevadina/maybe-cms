<template>
    <div class="mb-4">
        <div class="mb-3">{{ relation.title }}</div>
        <div class="overflow-auto select-list">
            <div class="text-center" v-if="loading">
                <div class="spinner-border my-5 text-secondary" role="status">
                    <span class="sr-only">Загружаем...</span>
                </div>
            </div>
            <div class="btn-group w-100 border mb-2" v-for="option in options" :key="option.id">
                <label class="w-100 d-flex align-items-center px-3 m-0">
                    <input type="checkbox" v-model="relation.related_posts" :value="option.id" class="me-2">
                    {{ option.title }}
                </label>
                <router-link :to="{name: 'Post', params: {postType: relation.related_post_type?.slug, id: option.id}}" class="btn btn-light" target="_blank">
                    <i class="fa-sharp fa-solid fa-arrow-up-right-from-square"></i>
                </router-link>
            </div>
        </div>
        <a href="#" data-bs-toggle="modal" :data-bs-target="`#add-post${relation.id}`" class="btn btn-outline-dark w-100"><i class="fas fa-plus"></i> Добавить {{ relation.related_post_type.title }}</a>
        <CreatePost :post-type="relation.related_post_type?.slug" :modal-key="`add-post${relation.id}`" @update="loadPostTypes"></CreatePost>
    </div>
</template>

<script>
import CreatePost from "../../views/posts/CreatePost.vue";

export default {
    name: "ManyToMany",
    props: {
        relation: {
            type: Object
        }
    },
    components: {CreatePost},
    data() {
        return {
            options: [],
            loading: true
        }
    },
    methods: {
        loadPostTypes: function() {
            this.loading = true
            this.getJson(`/api/posts/${this.relation.related_post_type?.slug}`,json => {
                this.options = json.data
                this.loading = false
            })
        }
    },
    mounted() {
        this.loadPostTypes()
    }
}
</script>
