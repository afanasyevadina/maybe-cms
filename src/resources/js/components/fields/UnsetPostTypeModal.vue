<template>
    <a href="#" class="text-decoration-none text-muted small mt-3" data-bs-toggle="modal" data-bs-target="#unset-post-type">Удалить источник</a>
    <div class="modal fade" tabindex="-1" id="unset-post-type">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" @submit.prevent="unsetPostType" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтверждение</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Посты будут откреплены.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Да, удалить</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Не надо</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "UnsetPostTypeModal",
    props: {
        block: {
            type: Object
        }
    },
    emits: ['update'],
    methods: {
        unsetPostType: function () {
            this.deleteRequest(`/api/blocks/${this.block.id}/post-type`, () => {
                this.$emit('update')
                this.hideModal()
            })
        }
    }
}
</script>
