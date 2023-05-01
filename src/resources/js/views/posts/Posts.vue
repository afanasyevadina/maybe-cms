<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>{{ model.plural_title }}</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-post" class="btn btn-success" v-if="posts.data.length">Добавить еще запись</a>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-border my-5 text-secondary" role="status">
                    <span class="sr-only">Загружаем...</span>
                </div>
            </div>
            <template v-else>
                <table class="table table-striped mb-4">
                    <tbody v-if="!posts.data.length">
                    <tr>
                        <td colspan="5" class="text-center py-3">
                            Пока нет ни одной записи
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-post" class="btn btn-outline-dark">Создать первую запись</a>
                        </td>
                    </tr>
                    </tbody>
                    <template v-else>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Автор</th>
                            <th>Последнее обновление</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="post in posts.data" :key="post.id">
                            <tr>
                                <td>{{ post.id }}</td>
                                <td>{{ post.title }}</td>
                                <td>{{ post.user.name }}</td>
                                <td>{{ formatDate(post.updated_at) }}</td>
                                <td class="text-nowrap text-end">
                                    <a :href="`/${postType}/${post.slug}`" class="btn btn-light me-2" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <router-link :to="{name: 'Post', params: {postType: postType, id: post.id}}" class="btn btn-light me-2">
                                        <i class="fas fa-pen"></i>
                                    </router-link>
                                    <DeletePost :id="post.id" :post-type="postType"></DeletePost>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </template>
                </table>
                <Pagination :pagination="posts.meta" @paginate="loadPosts"></Pagination>
            </template>
        </div>
        <CreatePost :postType="postType" :modal-key="'add-post'" @update="loadPosts(posts.meta.current_page)"></CreatePost>
    </div>
</template>

<script>
import CreatePost from "./CreatePost.vue";
import DeletePost from "./DeletePost.vue";
import Pagination from "../../components/Pagination.vue";

export default {
    name: 'Posts',
    props: ['postType'],
    components: {
        CreatePost,
        DeletePost,
        Pagination
    },
    data() {
        return {
            posts: {
                data: [],
                meta: {}
            },
            postTypes: [],
            loading: true
        }
    },
    computed: {
        model: function () {
            return this.postTypes.find(v => v.slug === this.postType) || {}
        }
    },
    methods: {
        loadPosts: function(page = 1) {
            this.loading = true
            this.getJson(`/api/posts/${this.postType}?page=${page}`, json => {
                this.posts = json
                this.loading = false
            })
        }
    },
    mounted() {
        this.loadPosts()
        this.getJson(`/api/post-types`, json => this.postTypes = json)
    }
}
</script>
