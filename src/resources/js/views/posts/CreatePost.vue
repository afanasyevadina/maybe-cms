<template>
    <div class="modal fade" :id="modalKey" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="save">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить запись</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Название</label>
                    <input type="text" required class="form-control" v-model="newPost.title">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal" :disabled="!newPost.title">Создать</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CreatePost',
    props: ['postType', 'modalKey'],
    data() {
        return {
            newPost: {}
        }
    },
    methods: {
        save: function () {
            this.postJson(`/api/posts/${this.postType}`, this.newPost, json => this.$emit('update', json.id))
            this.newPost = {}
        }
    }
}
</script>
