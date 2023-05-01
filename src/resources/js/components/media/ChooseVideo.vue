<template>
    <div class="modal fade" :id="modalKey" tabindex="-1">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="choose">
                <div class="modal-header">
                    <h5 class="modal-title">Выбрать видео</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center" v-if="loading">
                        <div class="spinner-border my-5 text-secondary" role="status">
                            <span class="sr-only">Загружаем...</span>
                        </div>
                    </div>
                    <template v-else-if="videos.data.length">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col-auto mb-4" v-for="video in videos.data" :key="video.id">
                                        <div class="card">
                                            <a href="#" class="card-body" @click.prevent="activeMedia = video">
                                                <video class="preview-img img-fluid border bg-light" :src="video.path" width="200"></video>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" v-if="activeMedia">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Title</h5>
                                        <button type="button" class="btn btn-close" @click.prevent="activeMedia = null"></button>
                                    </div>
                                    <div class="card-body">
                                        <video class="preview-img img-fluid mb-3 border bg-light" :src="activeMedia.path" controls></video>
                                        <div>Размер: {{ formatSize(activeMedia.size) }}</div>
                                        <div>Загружено: {{ formatDate(activeMedia.created_at) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <table class="table table-striped" v-else>
                        <tbody>
                        <tr>
                            <td class="text-center py-3">
                                Пока нет видео
                                <br>
                                <br>
                                <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#upload-video" class="btn btn-outline-dark">Загрузить первое видео</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        Нет нужного видео?
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#upload-video">Загрузи</a>
                    </div>
                    <div>
                        <button class="btn btn-success" :disabled="!activeMedia">Выбрать</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <Pagination :pagination="videos.meta" @paginate="loadFiles"></Pagination>
    <UploadVideo :modal-key="'upload-video'" @upload="upload"></UploadVideo>
</template>

<script>
import UploadVideo from "../../components/media/UploadVideo.vue";
import Pagination from "../Pagination.vue";
export default {
    name: 'ChooseVideo',
    props: ['modalKey'],
    components: {
        UploadVideo,
        Pagination
    },
    data() {
        return {
            videos: {
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
