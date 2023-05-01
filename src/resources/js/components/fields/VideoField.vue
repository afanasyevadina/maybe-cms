<template>
    <div>
        <template v-if="field.attachment?.file?.id">
            <div class="row">
                <div class="col-sm-6">
                    <video :src="field.attachment?.file?.path" :poster="field.attachment?.poster?.file?.path" class="img-fluid mb-3 preview-img border bg-light d-field" width="200"></video>
                    <div class="btn-group w-100 border">
                        <a :href="field.attachment?.file?.path" target="_blank"
                           class="btn btn-light text-start w-100 overflow-hidden">{{ field.attachment?.file?.original_name }}</a>
                        <button type="button" class="btn btn-light" @click.prevent="field.attachment = null">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <template v-if="field.attachment?.poster?.file?.id">
                        <img :src="field.attachment?.poster?.file?.path" alt="" class="img-fluid mb-3 preview-img border bg-light d-field" width="200">
                        <div class="btn-group w-100 border">
                            <a :href="field.attachment?.poster?.file?.path" target="_blank"
                               class="btn btn-light text-start w-100 overflow-hidden">{{ field.attachment?.poster?.file?.original_name }}</a>
                            <button type="button" class="btn btn-light" @click.prevent="field.attachment.poster = null">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </template>
                    <template v-else>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#choose-image-${field.id}`">
                            Выбрать постер
                        </button>
                        <ChooseImage :modal-key="`choose-image-${field.id}`" @choose="choosePoster"></ChooseImage>
                    </template>
                </div>
            </div>
        </template>
        <template v-else>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#choose-video-${field.id}`" :disabled="field.source">
                Выбрать видео
            </button>
            <ChooseVideo :modal-key="`choose-video-${field.id}`" @choose="chooseVideo"></ChooseVideo>
        </template>
    </div>
</template>

<script>
import ChooseVideo from "../media/ChooseVideo.vue";
import ChooseImage from "../media/ChooseImage.vue";
export default {
    name: "ImageField",
    props: {
        field: {
            type: Object
        }
    },
    components: { ChooseVideo, ChooseImage },
    methods: {
        chooseVideo: function (file) {
            (this.field.attachment = this.field.attachment || {}).file = file
            this.hideModal()
        },
        choosePoster: function (file) {
            this.field.attachment = this.field.attachment || {}
            this.field.attachment.poster = this.field.attachment?.poster || {}
            this.field.attachment.poster.file = file
            this.hideModal()
        }
    }
}
</script>
