<template>
    <div>
        <template v-if="field.attachment?.file?.id">
            <img :src="field.attachment?.file?.path" alt="" class="img-fluid mb-3 preview-img border bg-light" width="200">
            <div class="btn-group w-100 border">
                <a :href="field.attachment?.file?.path" target="_blank"
                   class="btn btn-light text-start w-100 overflow-hidden">{{ field.attachment?.file?.original_name }}</a>
                <button type="button" class="btn btn-light" @click.prevent="field.attachment = null">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </template>
        <template v-else>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#choose-image-${field.id}`">
                Выберите изображение
            </button>
            <ChooseImage :modal-key="`choose-image-${field.id}`" @choose="chooseImage"></ChooseImage>
        </template>
    </div>
</template>

<script>
import ChooseImage from "../media/ChooseImage.vue";
export default {
    name: "ImageField",
    props: {
        field: {
            type: Object
        }
    },
    components: { ChooseImage },
    methods: {
        chooseImage: function (file) {
            (this.field.attachment = this.field.attachment || {}).file = file
            this.hideModal()
        }
    }
}
</script>
