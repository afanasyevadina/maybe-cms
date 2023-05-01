<template>
    <div class="modal fade" tabindex="-1" :id="modalKey">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" @submit.prevent="remove" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтверждение</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Этот блок будет удален.</p>
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
import {mapMutations} from "vuex";

export default {
    name: "TreeDeleteModal",
    props: {
        block: {
            type: Object
        },
        modalKey: {
            type: String
        }
    },
    methods: {
        remove: function () {
            this.deleteRequest(`/api/blocks/${this.block.id}`, () => {
                this.hideModal()
                this.$emit('update')
                this.setActiveElement(null)
            })
        },
        ...mapMutations([
            'setActiveElement'
        ])
    }
}
</script>
