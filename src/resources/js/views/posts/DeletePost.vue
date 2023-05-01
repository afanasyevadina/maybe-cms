<template>
    <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-post-${id}`">
        <i class="fas fa-trash"></i>
    </a>
    <div class="modal fade" :id="`delete-post-${id}`" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="remove">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить запись</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    Мы сейчас удалим эту запись!
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Да, удаляйте</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Не надо</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

export default {
    name: 'DeletePost',
    props: {
        id: {
            type: Number
        },
        postType: {
            type: String
        }
    },
    methods: {
        remove: function () {
            this.deleteRequest(`/api/posts/${this.postType}/${this.id}`,() => {
                    this.$router.push({ name: 'Posts', params: {postType: this.postType} })
                    location.reload()
                })
        }
    }
}
</script>
