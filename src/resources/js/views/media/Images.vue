<template>
    <div class="p-4">
        <div class="row">
            <div class="col mb-4">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <router-link :to="{name: 'Images'}" class="nav-link active">Изображения</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'Video'}" class="nav-link">Видео</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'Files'}" class="nav-link">Файлы</router-link>
                    </li>
                </ul>
            </div>
            <div class="col-auto mb-4" v-if="images.data.length">
                <a href="#" data-bs-toggle="modal" data-bs-target="#upload-image" class="btn btn-success">Загрузить изображение</a>
            </div>
        </div>
        <div class="text-center" v-if="loading">
            <div class="spinner-border my-5 text-secondary" role="status">
                <span class="sr-only">Загружаем...</span>
            </div>
        </div>
        <template v-else-if="images.data.length">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-auto mb-4" v-for="image in images.data" :key="image.id">
                            <div class="card">
                                <a href="#" class="card-body" @click.prevent="activeMedia = image">
                                    <img class="preview-img img-fluid border bg-light" :src="image.path" alt="" width="200">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" v-if="activeMedia">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">File details</h5>
                            <button type="button" class="btn btn-close" @click.prevent="activeMedia = null"></button>
                        </div>
                        <div class="card-body">
                            <img class="preview-img img-fluid mb-3 border bg-light" :src="activeMedia.path" alt="">
                            <div>Original name: {{ activeMedia.original_name }}</div>
                            <div>Size: {{ formatSize(activeMedia.size) }}</div>
                            <div>Uploaded at: {{ formatDate(activeMedia.created_at) }}</div>
                            <div class="text-end">
                                <DeleteFile :id="activeMedia.id"></DeleteFile>
                            </div>
                        </div>
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#upload-image" class="btn btn-outline-dark">Загрузить первое изображение</a>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :pagination="images.meta" @paginate="loadFiles"></Pagination>
        <UploadImage :modal-key="'upload-image'" @upload="loadFiles"></UploadImage>
    </div>
</template>

<script>
import DeleteFile from "../../components/media/DeleteFile.vue";
import UploadImage from "../../components/media/UploadImage.vue";
import Pagination from "../../components/Pagination.vue";

export default {
    name: 'Images',
    components: {
        DeleteFile,
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
