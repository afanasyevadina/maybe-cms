<template>
    <div class="modal fade" id="add-page" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="save">
                <div class="modal-header">
                    <h5 class="modal-title">Новая страница</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Название страницы</label>
                    <input type="text" required class="form-control" v-model="newPage.title">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal" :disabled="!newPage.title">Создать</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CreatePage',
    data() {
        return {
            newPage: {}
        }
    },
    methods: {
        save: function () {
            this.postJson(`/api/pages`, this.newPage, json => this.$router.push({ name: 'Page', params: {id: json.id} }))
        }
    }
}
</script>
