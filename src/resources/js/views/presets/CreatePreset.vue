<template>
    <div class="modal fade" id="add-preset" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="save">
                <div class="modal-header">
                    <h5 class="modal-title">Новый шаблон</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Название</label>
                    <input type="text" required class="form-control" v-model="newPreset.title">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal" :disabled="!newPreset.title">Создать</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CreatePreset',
    data() {
        return {
            newPreset: {}
        }
    },
    methods: {
        save: function () {
            this.postJson(`/api/presets`, this.newPreset, json => this.$router.push({ name: 'Preset', params: {id: json.id} }))
        }
    }
}
</script>
