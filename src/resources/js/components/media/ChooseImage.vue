<template>
    <div class="modal fade" :id="modalKey" tabindex="-1">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="choose">
                <div class="modal-header">
                    <h5 class="modal-title">Выбрать картинку</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="text-center" v-if="loading">
                        <div class="spinner-border my-5 text-secondary" role="status">
                            <span class="sr-only">Загружаем...</span>
                        </div>
                    </div>
                    <template v-else-if="images.data.length">
                        <div class="row m-0 h-100">
                            <div class="col py-3 bg-light">
                                <div class="row">
                                    <div class="col-auto mb-4" v-for="image in images.data" :key="image.id">
                                        <div class="card position-relative">
                                            <label class="card-body c-pointer" @click.prevent="activeMedia = (activeMedia?.id === image.id ? null : image)">
                                                <img class="preview-img img-fluid border bg-light" :src="image.path" alt="" width="200">
                                            </label>
                                            <div class="text-end position-absolute w-100">
                                                <input type="checkbox" :checked="activeMedia?.id === image.id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 bg-white border-start" v-if="activeMedia">
                                <div class="sticky-top py-3">
                                    <img class="preview-img img-fluid mb-3 border bg-light" :src="activeMedia.path" alt="">
                                    <div>Имя файла: {{ activeMedia.original_name }}</div>
                                    <div>Размер: {{ formatSize(activeMedia.size) }}</div>
                                    <div>Загружено: {{ formatDate(activeMedia.created_at) }}</div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <table class="table table-striped" v-else>
                        <tbody>
                        <tr>
                            <td class="text-center py-3">
                                Пока нет изображений
                                <br>
                                <br>
                                <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#upload-image" class="btn btn-outline-dark">Загрузить первое изображение</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        Нет нужной картинки?
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#upload-image">Загрузи</a>
                    </div>
                    <div>
                        <button class="btn btn-success" :disabled="!activeMedia">Выбрать</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <Pagination :pagination="images.meta" @paginate="loadFiles"></Pagination>
    <UploadImage :modal-key="'upload-image'" @upload="upload"></UploadImage>
</template>

<script>
import UploadImage from "./UploadImage.vue";
import Pagination from "../../components/Pagination.vue";

export default {
    name: 'ChooseImage',
    props: ['modalKey'],
    emits: ['choose'],
    components: {
        UploadImage,
        Pagination
    },
    data() {
        return {
            images: {
                data: [],
                meta: {}
            },
            loading: true,
            activeMedia: null
        }
    },
    methods: {
        upload: function (media) {
            this.activeMedia = media
            this.choose()
        },
        choose: function () {
            this.$emit('choose', this.activeMedia)
        },
        loadFiles: function(page = 1) {
            this.loading = true
            this.getJson(`/api/files?type=image&page=${page}`,json => {
                this.images = json
                this.loading = false
            })
        }
    },
    mounted() {
        this.loadFiles()
    }
}
</script>
