<template>
    <div class="modal fade" id="add-component" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="save">
                <div class="modal-header">
                    <h5 class="modal-title">Новый компонент</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Название</label>
                    <input type="text" required class="form-control" v-model="newComponent.title">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal" :disabled="!newComponent.title">Создать</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CreateComponent',
    data() {
        return {
            newComponent: {}
        }
    },
    methods: {
        save: function () {
            this.postJson(`/api/components`, this.newComponent, json => this.$router.push({ name: 'Component', params: {id: json.id} }))
        }
    }
}
</script>
