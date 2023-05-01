<template>
    <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-file-${id}`">
        <i class="fas fa-trash"></i>
    </a>
    <div class="modal fade" :id="`delete-file-${id}`" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="remove">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить файл</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    Этот файл собираемся удалить.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Удаляйте</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Не надо</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DeleteFile',
    props: {
        id: {
            type: Number
        }
    },
    methods: {
        remove: function () {
            this.deleteRequest(`/api/files/${this.id}`,() => {
                location.reload()
            })
        }
    }
}
</script>
